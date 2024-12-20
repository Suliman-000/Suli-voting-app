@props([
    'type' => 'success',
    'redirect' => false,
    'messageToDisplay' => '',
])

<div
    x-cloak
    x-data="{
        isOpen: false,
        isError: @if ($type === 'success') false @elseif($type === 'error') true @endif,
        messageToDisplay: '{{ $messageToDisplay }}',
        showNotification(message) {
            this.isOpen = true
            this.messageToDisplay = message
            setTimeout(() => {
                this.isOpen = false
            }, 5000)
        }
    }"
    x-init="
        @if($redirect)
            $nextTick(() => showNotification(messageToDisplay))
        @else
            Livewire.on('ideaWasUpdated', message => {
                isError = false
                showNotification(message)
            })

            Livewire.on('ideaWasMarkedAsSpam', message => {
                isError = false
                showNotification(message)
            })

            Livewire.on('ideaWasMarkedAsNotSpam', message => {
                isError = false
                showNotification(message)
            })

            Livewire.on('statusWasUpdated', message => {
                isError = false
                showNotification(message)
            })

            Livewire.on('statusWasUpdatedError', message => {
                isError = true
                showNotification(message)
            })

            Livewire.on('commentWasAdded', message => {
                isError = false
                showNotification(message)
            })

            Livewire.on('commentWasUpdated', message => {
                isError = false
                showNotification(message)
            })

            Livewire.on('commentWasDeleted', message => {
                isError = false
                showNotification(message)
            })

            Livewire.on('commentWasMarkedAsSpam', message => {
                isError = false
                showNotification(message)
            })

            Livewire.on('commentWasMarkedAsNotSpam', message => {
                isError = false
                showNotification(message)
            })
        @endif
    "
    x-on:open-modal.window="isOpen = true"
    x-show="isOpen"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-x-8"
    x-transition:enter-end="opacity-100 translate-x-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 translate-x-0"
    x-transition:leave-end="opacity-0 translate-x-8"
    @keydown.escape.window="isOpen = false"
    x-on:close-modal.window="isOpen = false"
    class="z-20 flex justify-between max-w-xs sm:max-w-sm w-full fixed bottom-0 right-0 bg-white rounded-xl shadow-lg border px-4 py-5 mx-2 sm:mx-6 my-8"
>
    <div class="flex items-center">

        <svg x-show="!isError" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-green w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>

        <svg x-show="isError" class="text-red h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>

        <div class="ml-2 font-semibold text-gray-500 text-sm sm:text-base" x-text="messageToDisplay"></div>
    </div>
    <button @click="isOpen = false" class="text-gray-400 hover:text-gray-500">
        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
