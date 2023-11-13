<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Status;
use Livewire\Livewire;
use App\Models\Category;
use App\Livewire\CreateIdea;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateIdeaTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_idea_form_does_not_show_when_logged_out()
    {
        $response = $this->get(route('idea.index'));

        $response->assertSuccessful();
        $response->assertSee('Please login to create an idea.');
        $response->assertDontSee(' Let us know what you would like and we will take a look over!');
    }

    public function test_create_idea_form_does_show_when_logged_in()
    {
        $response = $this->actingAs(User::factory()->create())->get(route('idea.index'));

        $response->assertSuccessful();
        $response->assertDontSee('Please login to create an idea.');
        $response->assertSee(' Let us know what you would like and we will take a look over!');
    }

    public function test_main_page_contains_create_idea_livewire_component()
    {
        $this->actingAs(User::factory()->create())
            ->get(route('idea.index'))
            ->assertSeeLivewire('create-idea');
    }

    public function test_create_idea_form_validation_works()
    {
        Livewire::actingAs(User::factory()->create())
            ->test(CreateIdea::class)
            ->set('title', '')
            ->set('category', '')
            ->set('description', '')
            ->call('createIdea')
            ->assertHasErrors(['title', 'category', 'description'])
            ->assertSee('The title field is required');
    }

    public function test_creating_an_idea_works_correctly()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);

        Livewire::actingAs($user)
            ->test(CreateIdea::class)
            ->set('title', 'My first idea')
            ->set('category', $categoryOne->id)
            ->set('description', 'The description of the first idea')
            ->call('createIdea')
            ->assertRedirect('/');

        $response = $this->actingAs($user)->get(route('idea.index'));
        $response->assertSuccessful();
        $response->assertSee('My first idea');
        $response->assertSee('The description of the first idea');

        $this->assertDatabaseHas('ideas', [
            'title' => 'My first idea'
        ]);

        $this->assertDatabaseHas('votes', [
            'idea_id' => 1,
            'user_id' => 1,
        ]);
    }

    public function test_creating_Two_ideas_with_same_title_still_works_but_has_different_slugs()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);

        Livewire::actingAs($user)
            ->test(CreateIdea::class)
            ->set('title', 'My first idea')
            ->set('category', $categoryOne->id)
            ->set('description', 'The description of the first idea')
            ->call('createIdea')
            ->assertRedirect('/');

        $this->assertDatabaseHas('ideas', [
            'title' => 'My first idea',
            'slug' => 'my-first-idea',
        ]);

        Livewire::actingAs($user)
            ->test(CreateIdea::class)
            ->set('title', 'My first idea')
            ->set('category', $categoryOne->id)
            ->set('description', 'The description of the first idea')
            ->call('createIdea')
            ->assertRedirect('/');

        $this->assertDatabaseHas('ideas', [
            'title' => 'My first idea',
            'slug' => 'my-first-idea-2',
        ]);
    }
}
