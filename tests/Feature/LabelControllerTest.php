<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabelControllerTest extends TestCase
{
    use RefreshDatabase;

    public string $labelName;
    public string $taskName;
    public object $user1;
    public object $user2;
    public object $task;
    public object $status;
    public object $label;

    public function setUp(): void
    {
        parent::setUp();

        $this->user1 = User::factory()->create();
        $this->user2 = User::factory()->create();

        $this->status = TaskStatus::factory()->create();

        $this->taskName = 'Example task name';

        $this->task = new Task();
        $this->task->name = $this->taskName;
        $this->task->status_id = $this->status->id;
        $this->task->created_by_id = $this->user1->id;
        $this->task->assigned_to_id = $this->user2->id;
        $this->task->save();

        $this->labelName = 'Example label name';

        $this->label = new Label();
        $this->label->name = $this->labelName;
        $this->label->save();

        $this->task->labels()->attach($this->label->id);
    }

    public function testIndex(): void
    {
        $response = $this->get(route('labels.index'));

        $response->assertOk();
    }

    public function testCreate(): void
    {
        $response = $this->get(route('labels.create'));

        $response->assertForbidden();

        $response = $this->actingAs($this->user1)->get(route('labels.create'));

        $response->assertOk();
    }

    public function testStore(): void
    {
        $labelNameToStore = 'Example label name to store';
        $this->actingAs($this->user1)->post(route('labels.store'), [
            'name' => $labelNameToStore,
        ]);

        $this->assertDatabaseHas('labels', [
            'name' => $labelNameToStore,
        ]);
    }

    public function testEdit(): void
    {
        $response = $this->get(route('labels.edit', $this->label->id));

        $response->assertForbidden();

        $response = $this->actingAs($this->user1)->get(route('labels.edit', $this->label->id));

        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $labelNewName = 'Example label name to update';
        $this->actingAs($this->user1)->put(route('labels.update', $this->label->id), [
            'name' => $labelNewName,
        ]);

        $this->assertDatabaseHas('labels', [
            'name' => $labelNewName,
        ]);
    }

    public function testDestroy(): void
    {
        $response = $this->delete(route('labels.destroy', $this->label->id));

        $response->assertForbidden();

        $this->actingAs($this->user1)->delete(route('labels.destroy', $this->label->id));

        $this->assertModelExists($this->label);

        $this->labelUnbindedName = 'Example unbinded label name';

        $this->labelUnbinded = new Label();
        $this->labelUnbinded->name = $this->labelUnbindedName;
        $this->labelUnbinded->save();

        $this->actingAs($this->user1)->delete(route('labels.destroy', $this->labelUnbinded->id));

        $this->assertModelMissing($this->labelUnbinded);
    }
}
