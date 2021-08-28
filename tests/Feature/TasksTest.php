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
/** @test */
public function authenticated_users_can_create_a_new_task()
{
    //Given we have an authenticated user
    $test=\App\Models\User::factory()->create();
    $this->actingAs($test);
    //And a task object
    $task = \App\Models\Task::factory()->make();
    //When user submits post request to create task endpoint
    $this->post('/tasks',$task->toArray());
    //It gets stored in the database
    $this->assertEquals(1,\App\Models\Task::all()->count());
}
/** @test */
public function unauthenticated_users_cannot_create_a_new_task()
{
    //Given we have a task object
    $task = \App\Models\Task::factory()->make();

    //When unauthenticated user submits post request to create task endpoint
    // He should be redirected to login page
    $this->post('/tasks',$task->toArray())
         ->assertRedirect(url('/'));
}
}
