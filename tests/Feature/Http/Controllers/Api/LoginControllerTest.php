<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_good(): void
    {
        User::factory()->create([
            'email' => 'admin@admin.com',
            'password' => Hash::make('password')
        ]);

        $data = [
            'email' => 'admin@admin.com',
            'password' => 'password'
        ];

        $response = $this->json('POST', '/api/login', $data);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'token',
            'expires_at',
            'abilities'
        ]);
    }
}
