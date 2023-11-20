<?php

namespace App\Livewire;

use App\Models\Idea;
use Livewire\Component;
use App\Jobs\NotifyAllVoters;
use Illuminate\Support\Facades\Mail;
use App\Mail\IdeaStatusUpdatedMailable;

class SetStatus extends Component
{
    public $idea;
    public $status;
    public $notifyAllVoters;

    public function mount(Idea $idea)
    {
        $this->idea = $idea;
        $this->status = $this->idea->status_id;
    }

    public function setStatus()
    {
        if(! auth()->check() || ! auth()->user()->isAdmin()) {
            abort(403);
        }

        $this->idea->status_id = $this->status;
        $this->idea->save();

        if($this->notifyAllVoters) {
            NotifyAllVoters::dispatch($this->idea);
        }

        $this->dispatch('statusWasUpdated');
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.set-status');
    }
}
