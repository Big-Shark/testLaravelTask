<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class ApiTasksTest extends TestCase
{
    public function testApiTasks()
    {
        $response = $this->get('/api/tasks/');

        $response->assertStatus(200);
    }

    public function testApiCreateTask()
    {
        $response = $this->postJson('/api/tasks/', ['url' => 'http://127.0.0.1/test.zip']);

        $response->assertStatus(200);
    }

    public function testApiCreateTaskNotValid()
    {
        $response = $this->postJson('/api/tasks/', ['url' => '123']);

        $response->assertStatus(422);
    }
}
