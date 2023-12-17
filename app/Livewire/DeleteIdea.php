<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Idea;
use App\Models\Vote;
use Livewire\Component;

class DeleteIdea extends Component
{
    public $idea;

    public function mount(Idea $idea)
    {
        $this->idea = $idea;
    }

    public function deleteIdea()
    {
        // authorization
        if (auth()->guest() || auth()->user()->cannot('delete', $this->idea)) {
            abort(403);
        }

        Idea::destroy($this->idea->id);

        session()->flash('success_message', 'Idea has been deleted successfully!');

        return redirect()->route('idea.index');
    }

    public function render()
    {
        return view('livewire.delete-idea');
    }
}
