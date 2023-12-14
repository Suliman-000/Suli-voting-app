<div wire:poll="getNotificationsCount" x-data="{isOpen: false}" class="relative">
    <button @click=
        "isOpen = !isOpen
        if (isOpen) {
            Livewire.dispatch('getNotifications')
        }
    ">
        <svg viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-gray-500">
            <path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0113.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 01-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 11-7.48 0 24.585 24.585 0 01-4.831-1.244.75.75 0 01-.298-1.205A8.217 8.217 0 005.25 9.75V9zm4.502 8.9a2.25 2.25 0 104.496 0 25.057 25.057 0 01-4.496 0z" clip-rule="evenodd" />
        </svg>
        @if($notificationsCount)
            <div class="absolute rounded-full bg-red text-white text-xxs w-6 h-6 flex justify-center items-center border-2 -top-1 -right-1">{{ $notificationsCount }}</div>
        @endif
    </button>
    <ul x-show="isOpen" x-transition.origin.top.left @click.away="isOpen = false" @keydown.escape.window="isOpen = false" x-cloak class="absolute text-left text-gray-700 text-sm ml-8 w-76 md:w-96 bg-white shadow-dialog rounded-xl max-h-128 overflow-y-auto z-10 -right-28 md:-right-12">
        @if($notifications->isNotEmpty() && ! $isLoading)
            @foreach ($notifications as $notification)
                <li>
                    <a href="{{ route('idea.show', $notification->data['idea_slug']) }}" @click.prevent="isOpen = false" wire:click.prevent="markAsRead('{{ $notification->id }}')" class="flex hover:bg-gray-100 px-5 py-3 transition duration-150 ease-in">
                        <img src="{{ $notification->data['user_avatar'] }}" alt="avatar" class="w-10 h-10 rounded-xl"/>
                        <div class="ml-4">
                            <div class="line-clamp-6">
                                <span class="font-semibold">{{ $notification->data['user_name'] }}</span>
                                commented on
                                <span class="font-semibold">
                                    {{ $notification->data['idea_title'] }}
                                </span>:
                                <span>"{{ $notification->data['comment_body'] }}"</span>
                            </div>
                            <div class="text-xs text-gray-500 mt-2">{{ $notification->created_at->diffForHumans() }}</div>
                        </div>
                    </a>
                </li>
            @endforeach
            <li class="border-t border-gray-300 text-center">
                <button wire:click="markAllAsRead" @click="isOpen = false" class="w-full block font-semibold hover:bg-gray-100 px-5 py-4 transition duration-150 ease-in">
                    Mark all as read
                </button>
            </li>
        @elseif($isLoading)
            @foreach (range(1, 3) as $item)
                <li class="flex items-center px-5 py-3 transition duration-150 ease-in animate-pulse">
                    <div class="bg-gray-200 rounded-xl w-10 h-10"></div>
                    <div class="flex-1 ml-4 space-y-2">
                        <div class="bg-gray-200 w-full rounded h-4"></div>
                        <div class="bg-gray-200 w-full rounded h-4"></div>
                        <div class="bg-gray-200 w-1/2 rounded h-4"></div>
                    </div>
                </li>
            @endforeach
        @else
            <li class="mx-auto w-40 py-6">
                <img src="{{ asset('img/notfound.svg') }}" alt="not found image" class="mx-auto w-32 h-32" style="mix-blend-mode: luminosity">
                <div class="text-gray-400 text-center font-bold mt-6">No new Notifications...</div>
            </li>
        @endif
    </ul>
</div>
