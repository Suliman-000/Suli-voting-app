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

        Vote::where('idea_id', $this->idea->id)->delete();

        Comment::where('idea_id', $this->idea->id)->delete();

        Idea::destroy($this->idea->id);

        session()->flash('success_message', 'Idea has been deleted successfully!');

        return redirect()->route('idea.index');
    }

    public function render()
    {
        return view('livewire.delete-idea');
    }
}
