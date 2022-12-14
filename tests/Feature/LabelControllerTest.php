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
        $response = $this->actingAs($this->user)->get(route('labels.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $labelNameToStore = 'Example label name to store';
        $response = $this->actingAs($this->user)->post(route('labels.store'), [
            'name' => $labelNameToStore,
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('labels', [
            'name' => $labelNameToStore,
        ]);
    }

    public function testEdit(): void
    {
        $response = $this->actingAs($this->user)->get(route('labels.edit', $this->label->id));

        $response->assertSessionHasNoErrors();
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $labelNewName = 'Example label name to update';
        $response = $this->actingAs($this->user)->put(route('labels.update', $this->label->id), [
            'name' => $labelNewName,
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('labels', [
            'name' => $labelNewName,
        ]);
    }

    public function testDestroy(): void
    {
        $task = Task::factory()->create();
        $task->labels()->attach($this->label->id);

        $this->actingAs($this->user)->delete(route('labels.destroy', $this->label->id));
        $this->assertModelExists($this->label);

        $labelWithoutTask = Label::factory()->create();

        $this->actingAs($this->user)->delete(route('labels.destroy', $labelWithoutTask->id));
        $this->assertModelMissing($labelWithoutTask);
    }
}
