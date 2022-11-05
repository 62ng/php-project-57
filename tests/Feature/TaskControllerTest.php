<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public Task $task;
    public User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $user2 = User::factory()->create();
        $status = TaskStatus::factory()->create();

        $this->task = new Task();
        $this->task->name = 'Example task name';
        $this->task->status_id = $status->id;
        $this->task->created_by_id = $this->user->id;
        $this->task->assigned_to_id = $user2->id;
        $this->task->save();
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
        $user = User::find($this->task->created_by_id)->first();
        $this->actingAs($user)->put(route('tasks.update', $this->task->id), [
            'name' => $taskNewName,
            'status_id' => 1,
            'created_by_id' => $user['id'],
        ]);

        $this->assertDatabaseHas('tasks', [
            'name' => $taskNewName,
            'status_id' => 1,
            'created_by_id' => $user['id'],
        ]);
    }

    public function testDestroy(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->delete(route('tasks.destroy', $this->task->id));

        $response->assertForbidden();

        $user = User::find($this->task->created_by_id);
        $this->actingAs($user)->delete(route('tasks.destroy', $this->task->id));

        $this->assertModelMissing($this->task);
    }
}
