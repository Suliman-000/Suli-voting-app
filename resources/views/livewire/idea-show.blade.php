<div class="idea-and-buttons-container">
    <div class="idea-container mt-4 bg-white rounded-xl flex">
        <div class="flex flex-col md:flex-row flex-1 px-4 py-6">
            <div class="flex-none mx-4">
                <a href="#">
                    <img src="{{$idea->user->getAvatar() }}" alt="avatar" class="w-14 h-14 rounded-xl">
                </a>
            </div>
            <div class="w-full mx-2 md:mx-4">
                <h4 class="text-xl font-semibold mt-2 md:mt-0">
                    {{$idea->title}}
                </h4>
                <div class="text-gray-600 mt-3">
                    @admin
                        @if($idea->spam_reports > 0)
                            <div class="text-red mb-2">Spam reports: {{ $idea->spam_reports }}</div>
                        @endif
                    @endadmin
                    {{$idea->description}}
                </div>
                <div class="flex flex-col md:flex-row md:items-center justify-between mt-6">
                    <div class="flex items-center text xs text-gray-400 font-semibold space-x-2">
                        <div class="hidden md:block font-bold text-gray-900">{{$idea->user->name}}</div>
                        <div class="hidden md:block">&bull;</div>
                        <div>{{$idea->created_at->diffForHumans() }}</div>
                        <div>&bull;</div>
                        <div>{{$idea->category->name}}</div>
                        <div>&bull;</div>
                        <div class="text-gray-900">{{ $idea->comments()->count() }} comments</div>
                    </div>
                    <div x-data="{ isOpen: false}" class="flex items-center space-x-2 mt-4 md:mt-0">
                        <div class="{{ 'status-'.Str::kebab($idea->status->name) }} text-xxs font-bold uppercase leading-none rounded-full text-center w-28 h-7 py-2 px-4">{{$idea->status->name}}</div>
                        @auth
                            <div class="relative">
                                <button @click="isOpen = !isOpen" class="relative bg-gray-100 hover:bg-gray-200 border rounded-full h-7 py-2 px-3 transition duration-150 ease-in">
                                    <svg fill="#000000" height="auto" width="auto" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        viewBox="0 0 32.055 32.055" xml:space="preserve">
                                        <g>
                                            <path d="M3.968,12.061C1.775,12.061,0,13.835,0,16.027c0,2.192,1.773,3.967,3.968,3.967c2.189,0,3.966-1.772,3.966-3.967
                                                C7.934,13.835,6.157,12.061,3.968,12.061z M16.233,12.061c-2.188,0-3.968,1.773-3.968,3.965c0,2.192,1.778,3.967,3.968,3.967
                                                s3.97-1.772,3.97-3.967C20.201,13.835,18.423,12.061,16.233,12.061z M28.09,12.061c-2.192,0-3.969,1.774-3.969,3.967
                                                c0,2.19,1.774,3.965,3.969,3.965c2.188,0,3.965-1.772,3.965-3.965S30.278,12.061,28.09,12.061z"/>
                                        </g>
                                    </svg>
                                </button>
                                <ul x-show="isOpen" x-transition.origin.top.left @click.away="isOpen = false" @keydown.escape.window="isOpen = false" x-cloak class="absolute text-left ml-8 w-44 font-semibold bg-white shadow-dialog rounded-xl py-3 z-10 md:ml-8 top-8 md:top-6 right-0 md:left-0">
                                    @can('update', $idea)
                                        <li><a @click.prevent="isOpen = false; $dispatch('custom-show-edit-modal')" href="#" class="hover:bg-gray-100 px-5 py-3 block transition duration-150 ease-in">Edit Idea</a></li>
                                    @endcan
                                    @can('delete', $idea)
                                        <li><a @click.prevent="isOpen = false; $dispatch('custom-show-delete-modal')" href="#" class="hover:bg-gray-100 px-5 py-3 block transition duration-150 ease-in">Delete Idea</a></li>
                                    @endcan
                                    <li><a @click.prevent="isOpen = false; $dispatch('custom-show-mark-idea-as-spam-modal')" href="#" class="hover:bg-gray-100 px-5 py-3 block transition duration-150 ease-in">Mark as spam</a></li>
                                    @admin
                                    @if($idea->spam_reports > 0)
                                    <li><a @click.prevent="isOpen = false; $dispatch('custom-show-mark-idea-as-not-spam-modal')" href="#" class="hover:bg-gray-100 px-5 py-3 block transition duration-150 ease-in">Not Spam</a></li>
                                    @endif
                                    @endadmin
                                </ul>
                            </div>
                        @endauth
                    </div>
                    <div class="flex items-center md:hidden mt-4 md:mt-0">
                        <div class="bg-gray-100 text-center rounded-xl h-10 px-4 py-2 pr-8">
                            <div class="text-sm font-bold leading-none @if($hasVoted) text-blue @endif">{{ $votesCount }}</div>
                            <div class="text-xxs font-semibold leading-none text-gray-400">Votes</div>
                        </div>
                        @if($hasVoted)
                            <button wire:click.prevent="vote" class="w-20 bg-blue border border-blue hover:bg-blue-hover transition duration-150 ease-in font-bold text-xxs uppercase text-white rounded-xl px-4 py-3 -mx-5">Voted</button>
                        @else
                            <button wire:click.prevent="vote" class="w-20 bg-gray-200 border border-gray-200 hover:border-gray-400 transition duration-150 ease-in font-bold text-xxs uppercase rounded-xl px-4 py-3 -mx-5">Vote</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div> {{-- End idea container --}}

    <div class="buttons-container flex items-center justify-between mt-6">
        <div class="flex flex-col md:flex-row items-center space-x-4 md:ml-6">
            <livewire:add-comment :idea="$idea" />

            @admin
                <livewire:set-status :idea="$idea" />
            @endadmin

        </div>
        <div class="hidden md:flex items-center space-x-3">
            <div class="bg-white font-semibold text-center rounded xl px-3 py-2">
                <div class="text-xl leading-snug @if($hasVoted) text-blue @endif">{{$votesCount}}</div>
                <div class="text-gray-400 text-xs leading-none">Votes</div>
            </div>
            @if($hasVoted)
                <button wire:click.prevent="vote" type="button" class="w-32 h-11 text-xs bg-blue font-semibold rounded-xl uppercase text-white border border-blue hover:bg-blue-hover transition duration-150 ease-in px-6 py-3">
                    <span>Voted</span>
                </button>
            @else
                <button wire:click.prevent="vote" type="button" class="w-32 h-11 text-xs bg-gray-200 font-semibold rounded-xl uppercase border border-gray-200 hover:border-gray-400 transition duration-150 ease-in px-6 py-3">
                    <span>Vote</span>
                </button>
            @endif
        </div>
    </div> {{-- End buttons container --}}
</div> {{-- End idea and buttons container --}}
