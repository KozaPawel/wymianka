<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class RegisterTest extends TestCase
{
    public function test_user_with_valid_credentials_can_register(): void
    {
        $this->post('/register', [
            'name' => 'testowy',
            'email' => 'testowy@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertDatabaseHas('users', ['email' => 'testowy@example.com']);

        User::where('email', 'testowy@example.com')->delete();
    }

    public function test_user_with_duplicated_email_cannot_register(): void
    {
        User::factory()->create([
            'email' => 'testowy@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/register', [
            'name' => 'testowy',
            'email' => 'testowy@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors(['email']);

        User::where('email', 'testowy@example.com')->delete();
    }
}
