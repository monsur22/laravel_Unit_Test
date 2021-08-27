<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TasksTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_read_all_the_tasks()
    {
        $this->withoutExceptionHandling();

        //Given we have task in the database
        // $task = Task::factory()->create();
        // $task = factory('App\Models\Task')->create();
        $task = \App\Models\Task::factory()->create();


        //When user visit the tasks page
        $response = $this->get('/tasks');

        //He should be able to read the task
        $response->assertSee($task->title);
    }
/** @test */
    public function a_user_can_read_single_task()
    {
        //Given we have task in the database
        $task = \App\Models\Task::factory()->create();
        //When user visit the task's URI
        $response = $this->get('/tasks/'.$task->id);
        //He can see the task details
        $response->assertSee($task->title)
            ->assertSee($task->description);
    }
    /** @test */
public function a_task_requires_a_title(){

    // $this->actingAs(factory('App\Models\User')->create());
    $test=\App\Models\User::factory()->create();
    $this->actingAs($test);

    $task = \App\Models\Task::factory()->make(['title' => null]);

    $this->post('/tasks',$task->toArray())
            ->assertSessionHasErrors('title');
}

/** @test */
public function a_task_requires_a_description(){

    $test=\App\Models\User::factory()->create();
    $this->actingAs($test);

    $task = \App\Models\Task::factory()->make(['description' => null]);

    $this->post('/tasks',$task->toArray())
        ->assertSessionHasErrors('description');
}
}
