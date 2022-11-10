<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\Task;
use App\Models\User;
use Tests\TestCase;

class LabelControllerTest extends TestCase
{
    public User $user;
    public Label $label;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->label = Label::factory()->create();
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

        $response = $this->actingAs($this->user)->get(route('labels.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $labelNameToStore = 'Example label name to store';
        $this->actingAs($this->user)->post(route('labels.store'), [
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

        $response = $this->actingAs($this->user)->get(route('labels.edit', $this->label->id));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $labelNewName = 'Example label name to update';
        $this->actingAs($this->user)->put(route('labels.update', $this->label->id), [
            'name' => $labelNewName,
        ]);

        $this->assertDatabaseHas('labels', [
            'name' => $labelNewName,
        ]);
    }

    public function testDestroy(): void
    {
        $task = Task::factory()->create();
        $task->labels()->attach($this->label->id);

        $response = $this->delete(route('labels.destroy', $this->label->id));
        $response->assertForbidden();

        $this->actingAs($this->user)->delete(route('labels.destroy', $this->label->id));
        $this->assertModelExists($this->label);

        $labelDetached = Label::factory()->create();

        $this->actingAs($this->user)->delete(route('labels.destroy', $labelDetached->id));
        $this->assertModelMissing($labelDetached);
    }
}
