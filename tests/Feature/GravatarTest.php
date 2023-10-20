<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GravatarTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_generate_gravatar_default_image_when_no_email_found_a()
    {
        $user = User::factory()->create([
            'name' => 'Suliman',
            'email' => 'afakeemail@fakeemail.com',
        ]);

        $gravatarUrl = $user->getAvatar();

        $this->assertEquals(
            'https://gravatar.com/avatar/'.md5($user->email).'?s200&d=http://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-1.png',
            $gravatarUrl
        );

        $response = Http::get($user->getAvatar());

        $this->assertTrue($response->successful());
    }

    public function test_user_can_generate_gravatar_default_image_when_no_email_found_first_charactar_z()
    {
        $user = User::factory()->create([
            'name' => 'Suliman',
            'email' => 'zfakeemail@fakeemail.com',
        ]);

        $gravatarUrl = $user->getAvatar();

        $this->assertEquals(
            'https://gravatar.com/avatar/'.md5($user->email).'?s200&d=http://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-26.png',
            $gravatarUrl
        );

        $response = Http::get($user->getAvatar());

        $this->assertTrue($response->successful());
    }

    public function test_user_can_generate_gravatar_default_image_when_no_email_found_first_charactar_0()
    {
        $user = User::factory()->create([
            'name' => 'Suliman',
            'email' => '0fakeemail@fakeemail.com',
        ]);

        $gravatarUrl = $user->getAvatar();

        $this->assertEquals(
            'https://gravatar.com/avatar/'.md5($user->email).'?s200&d=http://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-27.png',
            $gravatarUrl
        );

        $response = Http::get($user->getAvatar());

        $this->assertTrue($response->successful());
    }

    public function test_user_can_generate_gravatar_default_image_when_no_email_found_first_charactar_9()
    {
        $user = User::factory()->create([
            'name' => 'Suliman',
            'email' => '9fakeemail@fakeemail.com',
        ]);

        $gravatarUrl = $user->getAvatar();

        $this->assertEquals(
            'https://gravatar.com/avatar/'.md5($user->email).'?s200&d=http://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-36.png',
            $gravatarUrl
        );

        $response = Http::get($user->getAvatar());

        $this->assertTrue($response->successful());
    }
}
