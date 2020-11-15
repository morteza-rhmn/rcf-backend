<?php

namespace Tests\Unit\Http\Controllers\API\V01\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{

    use RefreshDatabase;

    public function test_register_should_be_validate()
    {
        $response = $this->postJson('api/v1/auth/register');
        $response->assertStatus(422);
    }

    public function test_new_user_can_register()
    {
        $response = $this->postJson('api/v1/auth/register', [
            'name' => "Morteza Rahmani",
            'email' => "mor98rah@gmail.com",
            'password' => "12345678"
        ]);
        $response->assertStatus(201);
    }
}
