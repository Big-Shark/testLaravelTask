<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class TasksTest extends TestCase
{
    public function testTasks()
    {
        $response = $this->get('/tasks/');

        $response->assertStatus(200);
    }

    public function testCreateTask()
    {
        $response = $this->post('/tasks/', ['url' => 'http://127.0.0.1/test.zip']);
        $response->assertStatus(302);
    }

    public function testCreateTaskNotValid()
    {
        $response = $this->post('/tasks/', ['url' => '123']);
        $response->assertStatus(302);
    }
}
