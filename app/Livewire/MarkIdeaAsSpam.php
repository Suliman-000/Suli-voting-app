<?php

namespace App\Livewire;

use App\Models\Idea;
use Livewire\Component;

class MarkIdeaAsSpam extends Component
{
    public $idea;

    public function mount(Idea $idea)
    {
        $this->idea = $idea;
    }

    public function markAsSpam()
    {
        // authorization
        if (auth()->guest()) {
            abort(403);
        }

        $this->idea->spam_reports++;
        $this->idea->save();

        $this->dispatch('ideaWasMarkedAsSpam', 'Idea was marked as spam!');
        $this->dispatch('close-modal');
        $this->dispatch('open-modal');
    }

    public function render()
    {
        return view('livewire.mark-idea-as-spam');
    }
}
