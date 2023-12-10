<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Suli Voting app</title>

        {{-- this a dummy comment to epsiode 21: Fix back button bug when voting Miss --}}
        {{-- this a dummy comment to epsiode 51: Comments Pagination Miss --}}

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans bg-gray-background antialiased text-sm">
        <header class="flex flex-col md:flex-row items-center justify-between px-8 py-4">
            <a href="/"><img src="{{asset('img/logo-dark.svg')}}" alt="logo"></a>
            <div class="flex items-center mt-2 md:mt-0">
                @if (Route::has('login'))
                    <div class="px-6 py-4">
                        @auth
                            <div class="flex items-center space-x-4">
                            <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </a>
                                </form>

                                <div x-data="{isOpen: false}" class="relative">
                                    <button @click="isOpen = !isOpen">
                                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-gray-500">
                                            <path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0113.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 01-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 11-7.48 0 24.585 24.585 0 01-4.831-1.244.75.75 0 01-.298-1.205A8.217 8.217 0 005.25 9.75V9zm4.502 8.9a2.25 2.25 0 104.496 0 25.057 25.057 0 01-4.496 0z" clip-rule="evenodd" />
                                        </svg>
                                        <div class="absolute rounded-full bg-red text-white text-xxs w-6 h-6 flex justify-center items-center border-2 -top-1 -right-1">10</div>
                                    </button>
                                    <ul x-show="isOpen" x-transition.origin.top.left @click.away="isOpen = false" @keydown.escape.window="isOpen = false" x-cloak class="absolute text-left text-gray-700 text-sm ml-8 w-76 md:w-96 bg-white shadow-dialog rounded-xl max-h-128 overflow-y-auto z-10 -right-28 md:-right-12">
                                        <li>
                                            <a @click.prevent="isOpen = false;" href="#" class="flex hover:bg-gray-100 px-5 py-3 transition duration-150 ease-in">
                                                <img src="https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp" alt="avatar" class="w-10 h-10 rounded-xl"/>
                                                <div class="ml-4">
                                                    <div class="line-clamp-6">
                                                        <span class="font-semibold">John Doe</span>
                                                        commented on
                                                        <span class="font-semibold">
                                                            This is my idea
                                                        </span>:
                                                        <span>"Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nisi incidunt, vel perspiciatis quibusdam alias est qui modi minus temporibus sapiente nam culpa nulla voluptate sint placeat dolorem accusantium perferendis pariatur quod vero, quisquam voluptatum iste odit. Architecto nihil laborum hic deserunt aspernatur alias soluta, nemo labore, sint suscipit animi natus fugit aliquam molestiae qui adipisci. Cum labore quae repellendus ab enim quo ipsa adipisci animi eaque, sequi voluptatem aperiam provident saepe officiis unde aliquid magnam doloremque? Voluptatibus est quod molestiae magni cum deleniti sit quidem officia accusamus voluptatem exercitationem totam tenetur, veniam debitis? Libero modi error et labore, voluptatum repellendus!"</span>
                                                    </div>
                                                    <div class="text-xs text-gray-500 mt-2">1 hour ago</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a @click.prevent="isOpen = false;" href="#" class="flex hover:bg-gray-100 px-5 py-3 transition duration-150 ease-in">
                                                <img src="https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp" alt="avatar" class="w-10 h-10 rounded-xl"/>
                                                <div class="ml-4">
                                                    <div>
                                                        <span class="font-semibold">John Doe</span>
                                                        commented on
                                                        <span class="font-semibold">
                                                            This is my idea
                                                        </span>:
                                                        <span>"Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi pariatur tempore nihil minus numquam, aperiam eligendi soluta quis earum deserunt."</span>
                                                    </div>
                                                    <div class="text-xs text-gray-500 mt-2">1 hour ago</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a @click.prevent="isOpen = false;" href="#" class="flex hover:bg-gray-100 px-5 py-3 transition duration-150 ease-in">
                                                <img src="https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp" alt="avatar" class="w-10 h-10 rounded-xl"/>
                                                <div class="ml-4">
                                                    <div>
                                                        <span class="font-semibold">John Doe</span>
                                                        commented on
                                                        <span class="font-semibold">
                                                            This is my idea
                                                        </span>:
                                                        <span>"Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi pariatur tempore nihil minus numquam, aperiam eligendi soluta quis earum deserunt."</span>
                                                    </div>
                                                    <div class="text-xs text-gray-500 mt-2">1 hour ago</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a @click.prevent="isOpen = false;" href="#" class="flex hover:bg-gray-100 px-5 py-3 transition duration-150 ease-in">
                                                <img src="https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp" alt="avatar" class="w-10 h-10 rounded-xl"/>
                                                <div class="ml-4">
                                                    <div>
                                                        <span class="font-semibold">John Doe</span>
                                                        commented on
                                                        <span class="font-semibold">
                                                            This is my idea
                                                        </span>:
                                                        <span>"Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi pariatur tempore nihil minus numquam, aperiam eligendi soluta quis earum deserunt."</span>
                                                    </div>
                                                    <div class="text-xs text-gray-500 mt-2">1 hour ago</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="border-t border-gray-300 text-center">
                                            <a href="#" class="w-full block font-semibold hover:bg-gray-100 px-5 py-4 transition duration-150 ease-in">
                                                Mark all as read
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
                <a href="#">
                    <img src="https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp" alt="avatar" class="w-10 h-10 rounded-full"/>
                </a>
            </div>
        </header>

        <main class="container mx-auto max-w-custom flex flex-col md:flex-row">
            <div class="w-70 mx-auto md:mx-0 md:mr-5 mr-5">
                <div class="add-idea-container md:sticky md:top-8 bg-white border-2 border-blue rounded-xl mt-16">
                    <div class="text-center px-6 py-2 pt-6">
                        <h3 class="font-semibold text-base">Add an idea</h3>
                        <p class="text-xs mt-4">
                            @auth
                                Let us know what you would like and we will take a look over!
                            @else
                                Please login to create an idea.
                            @endauth
                        </p>
                    </div>
                    @auth
                        <livewire:create-idea />
                    @else
                            <div class="my-6 text-center">
                                <a href="{{route('login')}}" class="inline-block justify-center w-1/2 h-11 text-xs bg-blue text-white font-semibold rounded-xl border border-blue hover:bg-blue-hover transition duration-150 ease-in px-6 py-3">
                                    <span class="ml-1">Login</span>
                                </a>
                                <a href="{{route('register')}}" class="inline-block justify-center w-1/2 h-11 text-xs bg-gray-200 font-semibold rounded-xl border border-gray-200 hover:border-gray-400 transition duration-150 ease-in px-6 py-3 mt-4">
                                    <span class="ml-1">Register</span>
                                </a>
                            </div>
                    @endauth
                </div>
            </div>
            <div class="w-full px-2 md:px-0 md:w-175">
                <livewire:status-filters />
                <div class="mt-8">
                    {{ $slot }}
                </div>
            </div>

            @if(session('success_message'))
                <x-notification-success
                    :redirect="true"
                    message-to-display="{{ (session('success_message')) }}"
                />
            @endif

        </main>
        @livewireScripts
    </body>
</html>
