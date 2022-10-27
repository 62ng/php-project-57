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

    public string $statusName;
    public object $task;

    public function setUp(): void
    {
        parent::setUp();

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $status = TaskStatus::factory()->create();

        $this->taskName = 'Example task name';

        $this->task = new Task();
        $this->task->name = $this->taskName;
        $this->task->status_id = $status->id;
        $this->task->created_by_id = $user1->id;
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

        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('tasks.create'));

        $response->assertOk();
    }

    public function testStore(): void
    {
        $taskNameToStore = 'Example task name to store';
        $user = User::factory()->create();
        $this->actingAs($user)->post(route('tasks.store'), [
            'name' => $taskNameToStore,
            'status_id' => 1,
            'created_by_id' => $user->id,
        ]);

        $this->assertDatabaseHas('tasks', [
            'name' => $taskNameToStore,
            'status_id' => 1,
            'created_by_id' => $user->id,
        ]);
    }

    public function testEdit(): void
    {
        $response = $this->get(route('tasks.edit', $this->task->id));

        $response->assertForbidden();

        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('tasks.edit', $this->task->id));

        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $taskNewName = 'Example task name to update';
        $user = User::find($this->task->created_by_id);
        $this->actingAs($user)->put(route('tasks.update', $this->task->id), [
            'name' => $taskNewName,
            'status_id' => 1,
            'created_by_id' => $user->id,
        ]);

        $this->assertDatabaseHas('tasks', [
            'name' => $taskNewName,
            'status_id' => 1,
            'created_by_id' => $user->id,
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
