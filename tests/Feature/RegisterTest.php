<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:client --personal --name=Test');
    }

    private static array $userDataEmail = [
        'username' => 'newsiteuser',
        'email' => 'newsiteuser@gmail.com',
        'password' => 'password',
        'password_confirmation' => 'password',
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
    public function test_register_email_success(): void
    {
        $this->json('POST', '/api/v1/register/email', self::$userDataEmail
        )->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'user',
                'token_type',
                'token',
            ]);
    }

    /**
     * @return void
     */
    public function test_register_email_error_validation(): void
    {
        $this->json('POST', '/api/v1/register/email', []
        )->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors'
            ]);
    }

    /**
     * @return void
     */
    public function test_register_email_error_user_exist(): void
    {
        self::createUserEmail();
        $this->json('POST', '/api/v1/register/email', self::$userDataEmail
        )->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors'
            ]);
    }

    /**
     * @return void
     */
    public function test_register_email_error_wrong_method(): void
    {
        $this->json('PATCH', '/api/v1/register/email', self::$userDataEmail
        )->assertStatus(405);
    }


}
