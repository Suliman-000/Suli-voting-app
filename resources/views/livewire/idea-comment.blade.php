<div class="relative comment-container mt-4 bg-white rounded-xl flex">
    <div class="flex flex-col md:flex-row flex-1 px-4 py-6">
        <div class="flex-none">
            <a href="#">
                <img src="{{ $comment->user->getAvatar() }}" alt="avatar" class="w-14 h-14 rounded-xl">
            </a>
        </div>
        <div class="w-full md:mx-4">
            {{-- <h4 class="text-xl font-semibold">
                <a href="#" class="hover:underline">A random title can go here</a>
            </h4> --}}
            <div class="text-gray-600 line-clamp-3">
                {{ $comment->body }}
            </div>

            <div class="flex items-center justify-between mt-6">
                <div class="flex items-center text xs text-gray-400 font-semibold space-x-2">
                    <div class="font-bold text-gray-900">{{ $comment->user->name }}</div>
                    <div>&bull;</div>
                    <div>{{ $comment->created_at->diffForHumans() }}</div>
                </div>
                <div x-data="{ isOpen: false}" class="flex items-center space-x-2">
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
                        <ul x-show="isOpen" x-transition.origin.top.left @click.away="isOpen = false" @keydown.escape.window="isOpen = false" x-cloak class="absolute z-10 text-left ml-8 w-44 font-semibold bg-white shadow-dialog rounded-xl py-3 md:ml-8 top-8 md:top-6 right-0 md:left-0">
                            <li><a href="#" class="hover:bg-gray-100 px-5 py-3 block transition duration-150 ease-in">Mark as spam</a></li>
                            <li><a href="#" class="hover:bg-gray-100 px-5 py-3 block transition duration-150 ease-in">Delete</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> {{-- End comment container 1 --}}
