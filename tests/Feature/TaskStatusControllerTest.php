<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class TaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    public string $statusName;
    public object $status;

    public function setUp(): void
    {
        parent::setUp();

        $this->statusName = 'Example status name';

        $this->status = new TaskStatus();
        $this->status->name = $this->statusName;
        $this->status->save();
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

        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('task_statuses.create'));

        $response->assertOk();
    }

    public function testStore(): void
    {
        $statusNameToStore = 'Example status name to store';
        $user = User::factory()->create();
        $this->actingAs($user)->post(route('task_statuses.store'), [
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

        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('task_statuses.edit', $this->status->id));

        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $statusNewName = 'Example status name to update';
        $user = User::factory()->create();
        $this->actingAs($user)->put(route('task_statuses.update', $this->status->id), [
            'name' => $statusNewName,
        ]);

        $this->assertDatabaseHas('task_statuses', [
            'name' => $statusNewName,
        ]);
    }

    public function testDestroy(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->delete(route('task_statuses.destroy', $this->status->id));

        $this->assertModelMissing($this->status);
    }
}
