<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
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

    /**
     * @return void
     */
    private static function createUserEmail(): void
    {
        User::create([
            'username' => 'newsiteuser',
            'email' => 'newsiteuser@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }

    /**
     * @return void
     */
    public function test_login_email_success(): void
    {
        self::createUserEmail();
        $this->json('POST', '/api/v1/auth/email', self::$userDataEmail
        )->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'user',
                'token_type',
                'token',
            ]);
    }

    /**
     * @return void
     */
    public function test_login_email_error_validation(): void
    {
        $this->json('POST', '/api/v1/auth/email', []
        )->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors'
            ]);
    }

    /**
     * @return void
     */
    public function test_login_email_error_credentials(): void
    {
        self::createUserEmail();
        $this->json('POST', '/api/v1/auth/email', [
            'email' => 'newsiteuser@gmail.com',
            'password' => 'passwordx'
        ])->assertStatus(401)
            ->assertJsonStructure([
                'errors',
                'success'
            ]);
    }

    /**
     * @return void
     */
    public function test_login_email_error_wrong_method(): void
    {
        $this->json('PATCH', '/api/v1/auth/email', self::$userDataEmail
        )->assertStatus(405);
    }


    /**
     * @return void
     */
    public function test_logout_success(): void
    {
        self::createUserEmail();
        $response = $this->json('POST', '/api/v1/auth/email', self::$userDataEmail);

        $token_type = json_decode($response->getContent())->token_type;
        $token = json_decode($response->getContent())->token;

        $this->json('POST', '/api/v1/auth/logout', [], [
            'Authorization' => "$token_type $token"
        ])->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message'
            ]);
    }

    /**
     * @return void
     */
    public function test_logout_error_token(): void
    {
        self::createUserEmail();

        $this->json('POST', '/api/v1/auth/logout', [], [
            'Authorization' => "Bearer token"
        ])->assertStatus(401)
            ->assertJsonStructure([
                'success',
                'message'
            ]);
    }

    /**
     * @return void
     */
    public function test_logout_error_wrong_method(): void
    {
        $this->json('PATCH', '/api/v1/auth/logout')
            ->assertStatus(405);
    }


    /**
     * @return void
     */
    public function test_get_user_data_success(): void
    {
        self::createUserEmail();
        $response = $this->json('POST', '/api/v1/auth/email', self::$userDataEmail);

        $token_type = json_decode($response->getContent())->token_type;
        $token = json_decode($response->getContent())->token;

        $this->json('GET', '/api/v1/user-data', [], [
            'Authorization' => "$token_type $token"
        ])->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'username',
                'email',
            ]);
    }
    /**
     * @return void
     */
    public function test_get_user_data_error_wrong_method(): void
    {
        $this->json('PATCH', '/api/v1/user-data')
            ->assertStatus(405);
    }

}
