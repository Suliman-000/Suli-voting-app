<?php

namespace Tests\Feature\Filters;

use Tests\TestCase;
use App\Models\Idea;
use App\Models\User;
use App\Models\Status;
use Livewire\Livewire;
use App\Models\Category;
use App\Livewire\IdeasIndex;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_selecting_a_category_filters_correctly()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Idea',
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'description' => 'Description of my first idea',
        ]);

        $ideaTwo = idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Idea',
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'description' => 'Description of my first idea',
        ]);

        $ideaThree = idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Idea',
            'category_id' => $categoryTwo->id,
            'status_id' => $statusOpen->id,
            'description' => 'Description of my first idea',
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('category', 'Category 1')
            ->assertViewHas('ideas', function($ideas) {
                return $ideas->count() === 2
                    && $ideas->first()->category->name === 'Category 1';
            });
    }

    public function test_the_category_query_string_filters_correctly()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Idea',
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'description' => 'Description of my first idea',
        ]);

        $ideaTwo = idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Idea',
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'description' => 'Description of my first idea',
        ]);

        $ideaThree = idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Idea',
            'category_id' => $categoryTwo->id,
            'status_id' => $statusOpen->id,
            'description' => 'Description of my first idea',
        ]);

        Livewire::withQueryParams(['category' => 'Category 1'])
            ->test(IdeasIndex::class)
            ->assertViewHas('ideas', function($ideas) {
                return $ideas->count() === 2
                    && $ideas->first()->category->name === 'Category 1';
            });
    }

    public function test_selecting_a_status_and_a_category_filters_correctly()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open']);
        $statusConsidering = Status::factory()->create(['name' => 'Considering']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Idea',
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'description' => 'Description of my first idea',
        ]);

        $ideaTwo = idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Idea',
            'category_id' => $categoryOne->id,
            'status_id' => $statusConsidering->id,
            'description' => 'Description of my first idea',
        ]);

        $ideaThree = idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Idea',
            'category_id' => $categoryTwo->id,
            'status_id' => $statusOpen->id,
            'description' => 'Description of my first idea',
        ]);

        $ideaFour = idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Idea',
            'category_id' => $categoryTwo->id,
            'status_id' => $statusConsidering->id,
            'description' => 'Description of my first idea',
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('status', 'Open')
            ->set('category', 'Category 1')
            ->assertViewHas('ideas', function($ideas) {
                return $ideas->count() === 1
                    && $ideas->first()->category->name === 'Category 1'
                    && $ideas->first()->status->name === 'Open';
            });
    }

    public function test_the_category_query_string_filters_correctly_with_status_category()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open']);
        $statusConsidering = Status::factory()->create(['name' => 'Considering']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Idea',
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'description' => 'Description of my first idea',
        ]);

        $ideaTwo = idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Idea',
            'category_id' => $categoryOne->id,
            'status_id' => $statusConsidering->id,
            'description' => 'Description of my first idea',
        ]);

        $ideaThree = idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Idea',
            'category_id' => $categoryTwo->id,
            'status_id' => $statusOpen->id,
            'description' => 'Description of my first idea',
        ]);

        $ideaFour = idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Idea',
            'category_id' => $categoryTwo->id,
            'status_id' => $statusConsidering->id,
            'description' => 'Description of my first idea',
        ]);

        Livewire::withQueryParams(['category' => 'Category 1', 'status' => 'Open'])
            ->test(IdeasIndex::class)
            ->assertViewHas('ideas', function($ideas) {
                return $ideas->count() === 1
                    && $ideas->first()->category->name === 'Category 1'
                    && $ideas->first()->status->name === 'Open';
            });
    }

    public function test_selecting_all_categories_filters_correctly()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Idea',
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'description' => 'Description of my first idea',
        ]);

        $ideaTwo = idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My Second Idea',
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'description' => 'Description of my first idea',
        ]);

        $ideaThree = idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My Third Idea',
            'category_id' => $categoryTwo->id,
            'status_id' => $statusOpen->id,
            'description' => 'Description of my first idea',
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('category', 'All Categories')
            ->assertViewHas('ideas', function($ideas) {
                return $ideas->count() === 3;
            });
    }
}
