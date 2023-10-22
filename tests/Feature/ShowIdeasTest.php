<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Idea;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowIdeasTest extends TestCase
{
    use RefreshDatabase;


    public function test_list_of_ideas_shows_on_main_page()
    {
        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $ideaOne = idea::factory()->create([
            'title' => 'My First Idea',
            'category_id' => $categoryOne->id,
            'description' => 'Description of my first idea',
        ]);

        $ideaTwo = idea::factory()->create([
            'title' => 'My Second Idea',
            'category_id' => $categoryTwo->id,
            'description' => 'Description of my second idea',
        ]);

        $response = $this->get(route('idea.index'));

        $response->assertSuccessful();
        $response->assertSee($ideaOne->title);
        $response->assertSee($ideaOne->description);
        $response->assertSee($categoryOne->name);
        $response->assertSee($ideaTwo->title);
        $response->assertSee($ideaTwo->description);
        $response->assertSee($categoryTwo->name);
    }


    public function test_single_idea_shows_correctly_on_the_show_page()
    {
        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

        $idea = idea::factory()->create([
            'category_id' => $categoryOne->id,
            'title' => 'My First Idea',
            'description' => 'Description of my first idea',
        ]);

        $response = $this->get(route('idea.show', $idea));

        $response->assertSuccessful();
        $response->assertSee($idea->title);
        $response->assertSee($idea->description);
        $response->assertSee($categoryOne->name);
    }


    public function test_ideas_pagination_works()
    {
        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

        Idea::factory(Idea::PAGINATION_COUNT + 1)->create([
            'category_id' => $categoryOne->id,
        ]);

        $ideaOne = Idea::find(1);
        $ideaOne->title = 'My First Idea';
        $ideaOne->save();

        $ideaEleven = Idea::find(11);
        $ideaEleven->title = 'My Eleventh Idea';
        $ideaEleven->save();

        $response = $this->get('/');

        $response->assertSee($ideaOne->title);
        $response->assertDontSee($ideaEleven->title);

        $response = $this->get('/?page=2');

        $response->assertSee($ideaEleven->title);
        $response->assertDontSee($ideaOne->title);

    }


    public function test_same_idea_title_different_slugs()
    {
        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

        $ideaOne = Idea::factory()->create([
            'category_id' => $categoryOne->id,
            'title' => 'My First Idea',
        ]);
        $ideaTwo = Idea::factory()->create([
            'category_id' => $categoryOne->id,
            'title' => 'My First Idea',
        ]);

        $this->assertEquals('my-first-idea', $ideaOne->slug);
        $this->assertEquals('my-first-idea-2', $ideaTwo->slug);
    }

}
