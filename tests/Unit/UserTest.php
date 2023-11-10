<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_check_if_user_is_an_admin()
    {
        $user = User::factory()->make([
            'name' => 'Suliman',
            'email' => 'JohnDoe@gmail.com'
        ]);

        $userB = User::factory()->make([
            'name' => 'Suliman',
            'email' => 'user@gmail.com'
        ]);

        $this->assertTrue($user->isAdmin());
        $this->assertFalse($userB->isAdmin());
    }
}
