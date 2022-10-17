<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\View\View;
use SebastianBergmann\Type\VoidType;
use Tests\TestCase;


class TaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex(): void
    {
        $response = $this->get(route('task_statuses.index'));

        $response->assertOk();
    }

    public function testCreate(): void
    {
        $response = $this->get(route('task_statuses.create'));

        $response->assertOk();
    }

    public function testStore(): void
    {
        $statusName = 'Example';
        $this->post(route('task_statuses.store'), [
            'name' => $statusName,
        ]);

        $this->assertDatabaseHas('task_statuses', [
            'name' => $statusName,
        ]);
    }

    public function testEdit(): void
    {
        $statusName = 'Example';
        $status = new TaskStatus();
        $status->name = $statusName;
        $status->save();

        $response = $this->get(route('task_statuses.edit', $status->id));

        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $statusOldName = 'OldName';
        $statusNewName = 'NewName';

        $status = new TaskStatus();
        $status->name = $statusOldName;
        $status->save();

        $this->put(route('task_statuses.update', $status->id), [
            'name' => $statusNewName,
        ]);

        $this->assertDatabaseHas('task_statuses', [
            'name' => $statusNewName,
        ]);
    }

    public function testDestroy(): void
    {
        $statusName = 'Example';
        $status = new TaskStatus();
        $status->name = $statusName;
        $status->save();

        $this->delete(route('task_statuses.destroy', $status->id));

        $this->assertModelMissing($status);
    }
}
