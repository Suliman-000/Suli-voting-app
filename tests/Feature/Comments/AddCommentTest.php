<?php

namespace Tests\Feature\Comments;

use Tests\TestCase;
use App\Models\Idea;
use App\Models\User;
use Livewire\Livewire;
use App\Models\Comment;
use App\Livewire\AddComment;
use App\Notifications\CommentAdded;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddCommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_comment_livewire_component_renders()
    {
        $idea = Idea::factory()->create();

        $response = $this->get(route('idea.show', $idea));

        $response->assertSeeLivewire('add-comment');
    }

    public function test_add_comment_form_renders_when_user_is_logged_in()
    {
        $user = User::factory()->create();

        $idea = Idea::factory()->create();

        $response = $this->actingAs($user)->get(route('idea.show', $idea));

        $response->assertSee('Share your thoughts...');
    }

    public function test_add_comment_form_does_not_render_when_user_is_logged_out()
    {
        $idea = Idea::factory()->create();

        $response = $this->get(route('idea.show', $idea));

        $response->assertSee('Please login or create an account to post a comment.');
    }

    public function test_add_comment_form_validation_works()
    {
        $user = User::factory()->create();

        $idea = Idea::factory()->create();

        Livewire::actingAs($user)
            ->test(AddComment::class, [
                'idea' => $idea,
            ])
            ->set('comment', '')
            ->call('addComment')
            ->assertHasErrors(['comment'])
            ->set('comment', 'abc')
            ->call('addComment')
            ->assertHasErrors(['comment']);
    }

    public function test_add_comment_form_works()
    {
        $user = User::factory()->create();

        $idea = Idea::factory()->create();

        Notification::fake();

        Notification::assertNothingSent();

        Livewire::actingAs($user)
            ->test(AddComment::class, [
                'idea' => $idea,
            ])
            ->set('comment', 'This is my first Comment')
            ->call('addComment')
            ->assertDispatched('commentWasAdded');

        Notification::assertSentTo(
            [$idea->user], CommentAdded::class
        );

        $this->assertEquals(1, Comment::count());
        $this->assertEquals('This is my first Comment', $idea->comments->first()->body);
    }
}
