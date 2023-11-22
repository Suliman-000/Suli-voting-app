<?php

namespace App\Livewire;

use App\Models\Idea;
use Livewire\Component;

class MarkIdeaAsNotSpam extends Component
{
    public $idea;

    public function mount(Idea $idea)
    {
        $this->idea = $idea;
    }

    public function markAsNotSpam()
    {
        // authorization
        if (auth()->guest() || ! auth()->user()->isAdmin()) {
            abort(403);
        }

        $this->idea->spam_reports = 0;
        $this->idea->save();

        $this->dispatch('ideaWasMarkedAsNotSpam');
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.mark-idea-as-not-spam');
    }
}
