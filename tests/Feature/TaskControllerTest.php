<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    public User $user;
    public Task $task;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->task = Task::factory()->create([
            'created_by_id' => $this->user->id,
        ]);
    }

    public function testIndex(): void
    {
        $response = $this->get(route('tasks.index'));
        $response->assertOk();
    }

    public function testShow(): void
    {
        $response = $this->get(route('tasks.show', $this->task->id));
        $response->assertOk();
    }

    public function testCreate(): void
    {
        $response = $this->get(route('tasks.create'));
        $response->assertForbidden();

        $response = $this->actingAs($this->user)->get(route('tasks.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $taskNameToStore = 'Example task name to store';
        $this->actingAs($this->user)->post(route('tasks.store'), [
            'name' => $taskNameToStore,
            'status_id' => 1,
            'created_by_id' => $this->user->id,
        ]);

        $this->assertDatabaseHas('tasks', [
            'name' => $taskNameToStore,
            'status_id' => 1,
            'created_by_id' => $this->user->id,
        ]);
    }

    public function testEdit(): void
    {
        $response = $this->get(route('tasks.edit', $this->task->id));
        $response->assertForbidden();

        $response = $this->actingAs($this->user)->get(route('tasks.edit', $this->task->id));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $taskNewName = 'Example task name to update';
        $this->actingAs($this->user)->put(route('tasks.update', $this->task->id), [
            'name' => $taskNewName,
            'status_id' => 1,
            'created_by_id' => $this->user->id,
        ]);

        $this->assertDatabaseHas('tasks', [
            'name' => $taskNewName,
            'status_id' => 1,
            'created_by_id' => $this->user->id,
        ]);
    }

    public function testDestroy(): void
    {
        $userWithoutTask = User::factory()->create();
        $response = $this->actingAs($userWithoutTask)->delete(route('tasks.destroy', $this->task->id));
        $response->assertForbidden();

        $this->actingAs($this->user)->delete(route('tasks.destroy', $this->task->id));
        $this->assertModelMissing($this->task);
    }
}
