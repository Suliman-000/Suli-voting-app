<div
    x-cloak
    x-data="{ isOpen: false }"
    x-show="isOpen" @keydown.escape.window="isOpen = false"
    {{-- @custom-show-edit-modal.window="isOpen = true; $nextTick(() => $refs.title.focus())" --}}
    x-init="
        Livewire.on('commentWasUpdated' , () => {
            isOpen = false
        })

        Livewire.on('editCommentWasSet' , () => {
            isOpen = true
            $nextTick(() => $refs.editComment.focus())
        })
    "
    x-on:close-modal.window="isOpen = false"
    class="relative z-10"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
>

    <div x-show="isOpen" x-transition.duration.400ms class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center">
            <!--
                Modal panel, show/hide based on modal state.

                Entering: "ease-out duration-300"
                From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                To: "opacity-100 translate-y-0 sm:scale-100"
                Leaving: "ease-in duration-200"
                From: "opacity-100 translate-y-0 sm:scale-100"
                To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            -->
            <div x-show="isOpen" x-transition.origin.bottom.duration.400ms class="modal relative transform overflow-hidden rounded-tl-xl rounded-tr-xl bg-white transition-all py-4 sm:w-full sm:max-w-lg">
                <div class="absolute top-0 right-0 pt-4 pr-4">
                    <button @click="isOpen = false" class="text-gray-400 hover:text-gray-500">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <h3 class="text-center text-lg font-medium text-gray-900">Edit Comment</h3>
                    <form wire:submit.prevent="updateComment" action="#" method="POST" class="space-y-4 px-4 py-6">
                        <div>
                            <textarea x-ref="editComment" wire:model.defer="body" name="idea" id="idea" cols="30" rows="4" class="w-full bg-gray-100 border-none rounded-xl placeholder-gray-900 text-sm px-4 py-2" placeholder="Describe your comment..." required></textarea>
                            @error('body')
                                <p class="text-red text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center justify-between space-x-3">
                            <button type="button" class="flex items-center justify-center w-1/2 h-11 text-xs bg-gray-200 font-semibold rounded-xl border border-gray-200 hover:border-gray-400 transition duration-150 ease-in px-6 py-3">
                                <svg class="text-gray-600 w-4 -rotate-45" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                                </svg>
                                <span class="ml-1">Attach</span>
                            </button>
                            <button type="submit" class="flex items-center justify-center w-1/2 h-11 text-xs bg-blue text-white font-semibold rounded-xl border border-blue hover:bg-blue-hover transition duration-150 ease-in px-6 py-3">
                                <span class="ml-1">Update</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
