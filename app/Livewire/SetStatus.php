<?php

namespace App\Livewire;

use App\Models\Idea;
use Livewire\Component;

class SetStatus extends Component
{
    public $idea;
    public $status;

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

        $this->dispatch('statusWasUpdated');
    }

    public function render()
    {
        return view('livewire.set-status');
    }
}
