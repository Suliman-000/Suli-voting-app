<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Component;

class MarkCommentAsSpam extends Component
{
    public Comment $comment;

    protected $listeners = ['setMarkAsSpamComment'];

    public function setMarkAsSpamComment($commentId)
    {
        $this->comment = Comment::findOrFail($commentId);

        $this->dispatch('markAsSpamCommentWasSet');
    }

    public function markAsSpam()
    {
        if (auth()->guest()) {
            abort(403);
        }

        $this->comment->spam_reports++;
        $this->comment->save();

        $this->dispatch('commentWasMarkedAsSpam', 'Comment was Marked As Spam!');
    }

    public function render()
    {
        return view('livewire.mark-comment-as-spam');
    }
}
