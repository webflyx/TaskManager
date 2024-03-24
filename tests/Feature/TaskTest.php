<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:client --personal --name=Test');
    }

    private static array $userDataEmail = [
        'email' => 'newsiteuser@gmail.com',
        'password' => 'password',
    ];

    private static array $projectData = [
        'title' => 'New project',
        'description' => 'New project description',
    ];

    private static array $taskData = [
        'title' => 'New task',
        'description' => 'New task description',
        'status' => 'new',
    ];

    /**
     * @return void
     */
    private static function createUserEmail(): void
    {
        User::firstOrCreate([
            'email' => 'newsiteuser@gmail.com'
        ], [
            'username' => 'newsiteuser',
            'email' => 'newsiteuser@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }

    private function loginUserEmail(): string
    {
        self::createUserEmail();
        $response = $this->json('POST', '/api/v1/auth/email', self::$userDataEmail);

        $token_type = json_decode($response->getContent())->token_type;
        $token = json_decode($response->getContent())->token;

        return $token_type . ' ' . $token;
    }

    /**
     * @return int
     */
    private static function createProject(): int
    {
        self::createUserEmail();
        $project = Project::firstOrCreate([
            'title' => 'New title',
        ], [
            'title' => 'New title',
            'description' => 'New description',
            'user_id' => User::where('email', 'newsiteuser@gmail.com')->first()->id,
        ]);

        return $project->id;
    }

    /**
     * @return int
     */
    private function createTask(): int
    {
        self::createUserEmail();
        $project = self::createProject();

        $task = Task::create([
            'title' => 'New title',
            'description' => 'New description',
            'status' => 'new',
            'project_id' => $project,
        ]);

        return $task->id;
    }

    /**
     * @return void
     */
    public function test_create_task_success(): void
    {
        $token = $this->loginUserEmail();
        $project = self::createProject();

        $this->json('POST', '/api/v1/projects/' . $project . '/tasks', self::$taskData, [
            'Authorization' => "$token"
        ])->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message'
            ]);
    }

    /**
     * @return void
     */
    public function test_create_task_error_validation(): void
    {
        $token = $this->loginUserEmail();
        $project = self::createProject();

        $this->json('POST', '/api/v1/projects/' . $project . '/tasks', [], [
            'Authorization' => "$token"
        ])->assertStatus(422)
            ->assertJsonStructure([
                'errors',
                'message'
            ]);
    }

    /**
     * @return void
     */
    public function test_create_task_error_auth(): void
    {
        $project = self::createProject();

        $this->json('POST', '/api/v1/projects/' . $project . '/tasks', [], [
            'Authorization' => "XXX"
        ])->assertStatus(401)
            ->assertJsonStructure([
                'success',
                'message'
            ]);
    }

    /**
     * @return void
     */
    public function test_create_project_error_wrong_method(): void
    {
        $project = self::createProject();

        $this->json('PATCH', '/api/v1/projects/' . $project . '/tasks')
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function test_get_tasks_success(): void
    {
        $token = $this->loginUserEmail();
        $project = self::createProject();

        $this->json('GET', '/api/v1/projects/' . $project . '/tasks', [], [
            'Authorization' => "$token"
        ])->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'tasks',
                'links',
                'meta',
            ]);
    }

    /**
     * @return void
     */
    public function test_get_tasks_error_auth(): void
    {
        $project = self::createProject();

        $this->json('GET', '/api/v1/projects/' . $project . '/tasks', [], [
            'Authorization' => "XXX"
        ])->assertStatus(401)
            ->assertJsonStructure([
                'success',
                'message'
            ]);
    }

    /**
     * @return void
     */
    public function test_get_tasks_error_wrong_method(): void
    {
        $project = self::createProject();

        $this->json('PATCH', '/api/v1/projects/' . $project . '/tasks')
            ->assertStatus(405);
    }


    /**
     * @return void
     */
    public function test_update_task_success(): void
    {
        $token = $this->loginUserEmail();
        $project = self::createProject();
        $task = self::createTask();

        $this->json('PATCH', '/api/v1/projects/' . $project . '/tasks/' . $task, [
            'title' => 'Update title task',
            'description' => 'Update task description',
            'status' => 'complete',
        ], [
            'Authorization' => "$token"
        ])->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message'
            ]);
    }

    /**
     * @return void
     */
    public function test_update_task_error_auth(): void
    {
        $project = self::createProject();

        $this->json('PATCH', '/api/v1/projects/' . $project . '/tasks/1', [], [
            'Authorization' => "XXX"
        ])->assertStatus(401)
            ->assertJsonStructure([
                'success',
                'message'
            ]);
    }

    /**
     * @return void
     */
    public function test_update_task_error_wrong_method(): void
    {
        $project = self::createProject();

        $this->json('POST', '/api/v1/projects/' . $project . '/tasks/1')
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function test_get_task_success(): void
    {
        $token = $this->loginUserEmail();
        $project = self::createProject();
        $task = self::createTask();

        $this->json('GET', '/api/v1/projects/' . $project . '/tasks/' . $task, [], [
            'Authorization' => "$token"
        ])->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'task'
            ]);
    }

    /**
     * @return void
     */
    public function test_get_task_error_auth(): void
    {
        $project = self::createProject();

        $this->json('GET', '/api/v1/projects/' . $project .'/tasks/1', [], [
            'Authorization' => "XXX"
        ])->assertStatus(401)
            ->assertJsonStructure([
                'success',
                'message'
            ]);
    }

    /**
     * @return void
     */
    public function test_get_task_error_wrong_method(): void
    {
        $this->json('POST', '/api/v1/projects/1/tasks/1')
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function test_delete_task_success(): void
    {
        $token = $this->loginUserEmail();
        $project = self::createProject();
        $task = self::createTask();

        $this->json('DELETE', '/api/v1/projects/' . $project . '/tasks/' . $task, [], [
            'Authorization' => "$token"
        ])->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message'
            ]);
    }


    /**
     * @return void
     */
    public function test_delete_task_error_auth(): void
    {
        $project = self::createProject();

        $this->json('DELETE', '/api/v1/projects/' . $project . '/tasks/1', [], [
            'Authorization' => "XXX"
        ])->assertStatus(401)
            ->assertJsonStructure([
                'success',
                'message'
            ]);
    }

}
