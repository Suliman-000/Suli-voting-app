<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Component;

class MarkCommentAsNotSpam extends Component
{
    public Comment $comment;

    protected $listeners = ['setMarkAsNotSpamComment'];

    public function setMarkAsNotSpamComment($commentId)
    {
        $this->comment = Comment::findOrFail($commentId);

        $this->dispatch('markAsNotSpamCommentWasSet');
    }

    public function markAsNotSpam()
    {
        if (auth()->guest() || ! auth()->user()->isAdmin()) {
            abort(403);
        }

        $this->comment->spam_reports = 0;
        $this->comment->save();

        $this->dispatch('commentWasMarkedAsNotSpam', 'Spam counter as been reseted!');
    }

    public function render()
    {
        return view('livewire.mark-comment-as-not-spam');
    }
}
