<?php

namespace Tests\Unit\jobs;

use Tests\TestCase;
use App\Models\Idea;
use App\Models\User;
use App\Models\Vote;
use App\Models\Status;
use App\Models\Category;
use App\Jobs\NotifyAllVoters;
use Illuminate\Support\Facades\Mail;
use App\Mail\IdeaStatusUpdatedMailable;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotifyAllVotersTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_sends_an_email_to_all_voters()
    {
        $user = User::factory()->create([
            'email' => 'JohnDoe@gmail.com'
        ]);

        $userB = User::factory()->create([
            'email' => 'user@gmail.com'
        ]);

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

        $statusConsidering = Status::factory()->create(['id' => 2, 'name' => 'Considering']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusConsidering->id,
            'title' => 'My First Idea',
            'description' => 'Description of my first idea',
        ]);

        Vote::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $user->id,
        ]);

        Vote::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $userB->id,
        ]);

        Mail::fake();

        NotifyAllVoters::dispatch($idea);

        Mail::assertQueued(IdeaStatusUpdatedMailable::class, function($mail) {
            return $mail->hasTo('JohnDoe@gmail.com')
                && $mail->build()->subject === 'An idea you have voted for has a new status';
        });

        Mail::assertQueued(IdeaStatusUpdatedMailable::class, function($mail) {
            return $mail->hasTo('user@gmail.com')
                && $mail->build()->subject === 'An idea you have voted for has a new status';
        });
    }
}
