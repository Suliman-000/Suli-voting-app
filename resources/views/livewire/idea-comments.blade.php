<div>
    @if($comments->isNotEmpty())
        <div class="comments-container relative space-y-6 md:ml-22 pt-4 my-8 mt-1">

            @foreach ($comments as $comment)
                <livewire:idea-comment
                    :key="$comment->id"
                    :comment="$comment"
                    :ideaUserId="$idea->user->id"
                />
            @endforeach

        </div> {{-- End comments container --}}

        <div class="my-8 md:ml-22">
            {{ $comments->onEachSide(1)->links() }}
        </div>
    @else
        <div class="mx-auto w-70 mt-12">
            <img src="{{ asset('img/notfound.svg') }}" alt="not found image" class="mx-auto w-32 h-32 mix-blend-luminosity">
            <div class="text-gray-400 text-center font-bold mt-6">No Comments yet...</div>
        </div>
    @endif
</div>
