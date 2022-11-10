<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
{
    public User $user;
    public TaskStatus $status;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->status = TaskStatus::factory()->create();
    }

    public function testIndex(): void
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertOk();
    }

    public function testCreate(): void
    {
        $response = $this->get(route('task_statuses.create'));
        $response->assertForbidden();

        $response = $this->actingAs($this->user)->get(route('task_statuses.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $statusNameToStore = 'Example status name to store';
        $this->actingAs($this->user)->post(route('task_statuses.store'), [
            'name' => $statusNameToStore,
        ]);

        $this->assertDatabaseHas('task_statuses', [
            'name' => $statusNameToStore,
        ]);
    }

    public function testEdit(): void
    {
        $response = $this->get(route('task_statuses.edit', $this->status->id));
        $response->assertForbidden();

        $response = $this->actingAs($this->user)->get(route('task_statuses.edit', $this->status->id));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $statusNewName = 'Example status name to update';
        $this->actingAs($this->user)->put(route('task_statuses.update', $this->status->id), [
            'name' => $statusNewName,
        ]);

        $this->assertDatabaseHas('task_statuses', [
            'name' => $statusNewName,
        ]);
    }

    public function testDestroy(): void
    {
        Task::factory()->create([
            'status_id' => $this->status->id,
        ]);

        $response = $this->delete(route('task_statuses.destroy', $this->status->id));
        $response->assertForbidden();

        $this->actingAs($this->user)->delete(route('task_statuses.destroy', $this->status->id));
        $this->assertModelExists($this->status);

        $statusWithoutTask = TaskStatus::factory()->create();
        $this->actingAs($this->user)->delete(route('task_statuses.destroy', $statusWithoutTask->id));
        $this->assertModelMissing($statusWithoutTask);
    }
}
