<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    public function test_user_with_valid_credentials_can_log_in(): void
    {
        $user = User::factory()->create([
            'email' => 'tst@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->post('/login', [
            'email' => 'tst@example.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);

        User::find($user->id)->delete();
    }

    public function test_user_with_invalid_credentials_cannot_log_in(): void
    {
        $user = User::factory()->create([
            'email' => 'tst@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->post('/login', [
            'email' => 'tst@example.com',
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest();

        User::find($user->id)->delete();
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        $this->delete('/logout');
        $this->assertGuest();

        User::find($user->id)->delete();
    }
}
