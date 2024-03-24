<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProjectTest extends TestCase
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

    /**
     * @return void
     */
    private static function createUserEmail(): void
    {
        User::firstOrCreate([
            'email' => 'newsiteuser@gmail.com'
        ],[
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
    private function createProject(): int
    {
        self::createUserEmail();
        $project = Project::create([
            'title' => 'New title',
            'description' => 'New description',
            'user_id' => User::where('email', 'newsiteuser@gmail.com')->first()->id,
        ]);

        return $project->id;
    }

    /**
     * @return void
     */
    public function test_create_project_success(): void
    {
        $token = $this->loginUserEmail();

        $this->json('POST', '/api/v1/projects', [
            'title' => 'New project',
            'description' => 'New project description',
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
    public function test_create_project_error_validation(): void
    {
        $token = $this->loginUserEmail();

        $this->json('POST', '/api/v1/projects', [], [
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
    public function test_create_project_error_auth(): void
    {
        $this->json('POST', '/api/v1/projects', [], [
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
        $this->json('PATCH', '/api/v1/projects')
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function test_get_projects_success(): void
    {
        $token = $this->loginUserEmail();

        $this->json('GET', '/api/v1/projects', [], [
            'Authorization' => "$token"
        ])->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'projects',
                'links',
                'meta',
            ]);
    }

    /**
     * @return void
     */
    public function test_get_projects_error_auth(): void
    {
        $this->json('GET', '/api/v1/projects', [], [
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
    public function test_get_projects_error_wrong_method(): void
    {
        $this->json('PATCH', '/api/v1/projects')
            ->assertStatus(405);
    }


    /**
     * @return void
     */
    public function test_update_project_success(): void
    {
        $token = $this->loginUserEmail();
        $project = $this->createProject();

        $this->json('PATCH', '/api/v1/projects/' . $project, [
            'title' => 'Update title project',
            'description' => 'Update project description',
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
    public function test_update_project_error_auth(): void
    {
        $project = $this->createProject();

        $this->json('PATCH', '/api/v1/projects/' . $project, [], [
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
    public function test_update_project_error_wrong_method(): void
    {
        $project = $this->createProject();

        $this->json('POST', '/api/v1/projects/' . $project)
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function test_get_project_success(): void
    {
        $token = $this->loginUserEmail();
        $project = $this->createProject();

        $this->json('GET', '/api/v1/projects/'.$project, [], [
            'Authorization' => "$token"
        ])->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'project'
            ]);
    }

    /**
     * @return void
     */
    public function test_get_project_error_auth(): void
    {
        $project = $this->createProject();

        $this->json('GET', '/api/v1/projects/'.$project, [], [
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
    public function test_get_project_error_wrong_method(): void
    {
        $this->json('POST', '/api/v1/projects/1')
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function test_delete_project_success(): void
    {
        $token = $this->loginUserEmail();
        $project = $this->createProject();

        $this->json('DELETE', '/api/v1/projects/'.$project, [], [
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
    public function test_delete_project_error_auth(): void
    {
        $project = $this->createProject();

        $this->json('DELETE', '/api/v1/projects/'.$project, [], [
            'Authorization' => "XXX"
        ])->assertStatus(401)
            ->assertJsonStructure([
                'success',
                'message'
            ]);
    }

}
