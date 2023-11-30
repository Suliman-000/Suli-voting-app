<div>
    @if($comments->isNotEmpty())
        <div class="relative comments-container space-y-6 md:ml-22 pt-4 my-8 mt-1">

            @foreach ($comments as $comment)
                <livewire:idea-comment
                    :key="$comment->id"
                    :comment="$comment"
                />
            @endforeach

        </div> {{-- End comments container --}}
    @else
        <div class="mx-auto w-70 mt-12">
            <img src="{{ asset('img/notfound.svg') }}" alt="not found image" class="mx-auto w-32 h-32" style="mix-blend-mode: luminosity">
            <div class="text-gray-400 text-center font-bold mt-6">No Ideas were found...</div>
        </div>
    @endif
</div>
