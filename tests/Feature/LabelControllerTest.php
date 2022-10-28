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

        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('labels.create'));

        $response->assertOk();
    }

    public function testStore(): void
    {
        $labelNameToStore = 'Example label name to store';
        $user = User::factory()->create();
        $this->actingAs($user)->post(route('labels.store'), [
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

        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('labels.edit', $this->label->id));

        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $labelNewName = 'Example label name to update';
        $user = User::factory()->create();
        $this->actingAs($user)->put(route('labels.update', $this->label->id), [
            'name' => $labelNewName,
        ]);

        $this->assertDatabaseHas('labels', [
            'name' => $labelNewName,
        ]);
    }

    public function testDestroy(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->delete(route('labels.destroy', $this->label->id));

        $response->assertForbidden();

        $user = User::find($this->user1->id);
        $this->actingAs($user)->delete(route('labels.destroy', $this->label->id));

//        $this->assertDatabaseMissing('label_task', [
//            'label_id' => $this->label->id,
//            'task_id' => $this->task->id,
//        ]);
        $this->assertModelMissing($this->label);
    }
}
