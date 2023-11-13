<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Idea;
use App\Models\User;
use App\Models\Status;
use Livewire\Livewire;
use App\Models\Category;
use App\Livewire\SetStatus;
use App\Jobs\NotifyAllVoters;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminSetStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_page_contains_set_status_livewire_component_when_user_is_admin()
    {
        $user = User::factory()->admin()->create();
        $idea = Idea::factory()->create();

        $this->actingAs($user)
            ->get(route('idea.show', $idea))
            ->assertSeeLivewire('set-status');
    }

    public function test_show_page_does_not_contain_set_status_livewire_component_when_user_is_not_admin()
    {
        $user = User::factory()->create([
            'email' => 'user@gmail.com',
        ]);

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryOne = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'Description of my first idea',
        ]);

        $this->actingAs($user)
            ->get(route('idea.show', $idea))
            ->assertDontSeeLivewire('set-status');
    }

    public function test_initial_status_is_set_correctly()
    {
        $user = User::factory()->create([
            'email' => 'JohnDoe@gmail.com',
        ]);

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryOne = Category::factory()->create(['name' => 'Category 2']);

        $statusConsidering = Status::factory()->create(['id' => 2, 'name' => 'Considering']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusConsidering->id,
            'title' => 'My First Idea',
            'description' => 'Description of my first idea',
        ]);

        Livewire::actingAs($user)
            ->test(SetStatus::class, [
                'idea' => $idea,
            ])
            ->assertSet('status', $statusConsidering->id);
    }

    public function test_can_set_status_correctly()
    {
        $user = User::factory()->create([
            'email' => 'JohnDoe@gmail.com',
        ]);

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryOne = Category::factory()->create(['name' => 'Category 2']);

        $statusConsidering = Status::factory()->create(['id' => 2, 'name' => 'Considering']);
        $statusInProgress = Status::factory()->create(['id' => 3, 'name' => 'In Progress']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusConsidering->id,
            'title' => 'My First Idea',
            'description' => 'Description of my first idea',
        ]);

        Livewire::actingAs($user)
            ->test(SetStatus::class, [
                'idea' => $idea,
            ])
            ->set('status', $statusInProgress->id)
            ->call('setStatus')
            ->assertDispatched('statusWasUpdated');

        $this->assertDatabaseHas('ideas', [
            'id' => $idea->id,
            'status_id' => $statusInProgress->id,
        ]);
    }

    public function test_can_set_status_correctly_while_notifying_all_voters()
    {
        $user = User::factory()->create([
            'email' => 'JohnDoe@gmail.com',
        ]);

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

        $statusConsidering = Status::factory()->create(['id' => 2, 'name' => 'Considering']);
        $statusInProgress = Status::factory()->create(['id' => 3, 'name' => 'In Progress']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusConsidering->id,
            'title' => 'My First Idea',
            'description' => 'Description of my first idea',
        ]);

        Queue::fake();

        Queue::assertNothingPushed();

        Livewire::actingAs($user)
            ->test(SetStatus::class, [
                'idea' => $idea,
            ])
            ->set('status', $statusInProgress->id)
            ->set('notifyAllVoters', true)
            ->call('setStatus')
            ->assertDispatched('statusWasUpdated');

        Queue::assertPushed(NotifyAllVoters::class);
    }
}
