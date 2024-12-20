<?php

namespace App\Livewire;

use App\Models\Idea;
use Livewire\Component;
use App\Models\Category;

class EditIdea extends Component
{
    public $idea;
    public $title;
    public $category;
    public $description;

    protected $rules = [
        'title' => 'required|min:4',
        'category' => 'required|integer|exists:categories,id',
        'description' => 'required|min:4',
    ];

    public function mount(Idea $idea)
    {
        $this->idea = $idea;
        $this->title = $idea->title;
        $this->category = $idea->category_id;
        $this->description = $idea->description;
    }

    public function updateIdea()
    {
        // Authorization

        if (auth()->guest() || auth()->user()->cannot('update', $this->idea)) {
            abort(403);
        }

        $this->validate();

        $this->idea->update([
            'title' => $this->title,
            'category_id' => $this->category,
            'description' => $this->description,
        ]);

        $this->dispatch('ideaWasUpdated', 'Idea was updated successfully!');
        $this->dispatch('close-modal');
        $this->dispatch('open-modal');
    }

    public function render()
    {
        return view('livewire.edit-idea', [
            'categories' => Category::all(),
        ]);
    }
}
