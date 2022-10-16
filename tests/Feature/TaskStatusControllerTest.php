<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
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

    public function  testStore(): void
    {
        $statusName = 'Example';
        $this->post(route('task_statuses.index'), [
            'name' => $statusName,
        ]);

        $this->assertDatabaseHas('task_statuses', [
            'name' => $statusName,
        ]);
    }
}
