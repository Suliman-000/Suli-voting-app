<?php

namespace App\Livewire;

use App\Livewire\Traits\WithAuthRedirects;
use App\Models\Comment;
use App\Models\Idea;
use App\Notifications\CommentAdded;
use Livewire\Component;

class AddComment extends Component
{
    use WithAuthRedirects;

    public $idea;
    public $comment;
    protected $rules = [
        'comment' => 'required|min:4',
    ];

    public function mount(Idea $idea)
    {
        $this->idea = $idea;
    }

    public function addComment()
    {
        // authorization
        if (auth()->guest()) {
            abort(403);
        }

        $this->validate();

        $newComment = Comment::create([
            'user_id' => auth()->id(),
            'idea_id' => $this->idea->id,
            'body' => $this->comment,
            'status_id' => 1,
        ]);

        $this->reset('comment');

        $this->idea->user->notify(new CommentAdded($newComment));

        $this->dispatch('commentWasAdded', 'Comment was posted!');
        $this->dispatch('close-modal');
        $this->dispatch('open-modal');
    }

    public function render()
    {
        return view('livewire.add-comment');
    }
}
