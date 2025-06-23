<nav class="bg-gray-800" x-data="{ isOpen: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
                <div class="shrink-0">
                    <img class="size-8"
                        src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
                        alt="Your Company">
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">

                        {{-- menentukan link mana yang aktif (current) dengan membaca url aktif menggunakan method
                        request --}}
                        <x-my-nav-link href='/' :current="request()->is('/')">Home</x-my-nav-link>
                        <x-my-nav-link href='/posts' :current="request()->is('posts')">Blog</x-my-nav-link>
                        <x-my-nav-link href='/about' :current="request()->is('about')">About</x-my-nav-link>
                        <x-my-nav-link href='/contact' :current="request()->is('contact')">Contact</x-my-nav-link>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">

                    <!-- Profile dropdown -->
                    <div class="relative ml-3">
                        @if (Auth::check())
                            <div>
                                <button type="button" @click="isOpen = !isOpen"
                                    class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm text-gray-300 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden cursor-pointer"
                                    id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="absolute -inset-1.5"></span>
                                    <span class="sr-only">Open user menu</span>
                                    <img class="size-8 rounded-full object-cover"
                                        src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('../img/default-avatar.jpeg') }}"
                                        alt="{{ Auth::user()->name }}">
                                    <div class="ml-3 text-xs font-medium">{{ Auth::user()->name }}</div>
                                    <svg class="fill-current h-4 w-4 ml-2" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                            <div x-show="isOpen" x-transition:enter="transition ease-out duration-100 transform"
                                x-transition:enter-start="opacity-0 scale-65"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75 transform"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-65"
                                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5 focus:outline-hidden"
                                role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                tabindex="-1">
                                <!-- Active: "bg-gray-100 outline-hidden", Not Active: "" -->
                                <a href="/profile" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                    tabindex="-1" id="user-menu-item-0">Your Profile</a>
                                <a href="/dashboard" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                    tabindex="-1" id="user-menu-item-1">Settings</a>
                                <form method="POST" action="/logout">
                                    {{-- taambahkan csrf biar aman dari serangan hacker --}}
                                    @csrf
                                    <button type="submit" class="block px-4 py-2 text-sm text-gray-700 cursor-pointer"
                                        role="menuitem" tabindex="-1" id="user-menu-item-2">Log out</button>
                                </form>
                            </div>
                        @else
                            <a href="/login" class="text-white hover:text-white/70 text-sm cursor-pointer">Login</a>
                            <span class="text-white mx-2.5 font-medium">|</span>
                            <a href="/register" class="text-white hover:text-white/70 text-sm">Register</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="-mr-2 flex md:hidden">
                <!-- Mobile menu button -->
                <button type="button" @click="isOpen = !isOpen"
                    class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Open main menu</span>
                    <!-- Menu open: "hidden", Menu closed: "block" -->
                    <svg :class="{ 'hidden': isOpen, 'block': !isOpen }" class="block size-6" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                        data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <!-- Menu open: "block", Menu closed: "hidden" -->
                    <svg :class="{ 'block': isOpen, 'hidden': !isOpen }" class="size-6" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                        data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div x-show="isOpen" class="md:hidden" id="mobile-menu">
        <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
            {{-- menentukan link mana yang aktif (current) dengan membaca url aktif menggunakan method request --}}
            <x-my-nav-link class="block" href='/' :current="request()->is('/')">Home</x-my-nav-link>
            <x-my-nav-link class="block" href='/posts' :current="request()->is('blog')">Blog</x-my-nav-link>
            <x-my-nav-link class="block" href='/about' :current="request()->is('about')">About</x-my-nav-link>
            <x-my-nav-link class="block" href='/contact' :current="request()->is('contact')">Contact</x-my-nav-link>
        </div>
        <div class="border-t border-gray-700 pt-4 pb-3">
            @if (Auth::check())
                <div class="flex items-center px-5">
                    <div class="shrink-0">
                        <img class="size-10 rounded-full object-cover"
                            src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('../img/default-avatar.jpeg') }}"
                            alt="{{ Auth::user()->name }}">
                    </div>
                    <div class="ml-4 text-sm">
                        <div class="text-white font-medium mt-1">{{ Auth::user()->name }}</div>
                        <div class="text-gray-400">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1 px-2 text-sm">
                    <a href="/profile"
                        class="block rounded-md px-3 py-2 font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Your
                        Profile</a>
                    <a href="/dashboard"
                        class="block rounded-md px-3 py-2 font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Settings</a>
                    <form method="POST" action="/logout">
                        {{-- taambahkan csrf biar aman dari serangan hacker --}}
                        @csrf
                        <button type="submit"
                            class="block w-full text-left rounded-md px-3 py-2 font-medium text-gray-400 hover:bg-gray-700 hover:text-white cursor-pointer">Log
                            out</button>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1 px-2 text-sm text-white">
                    <a href="/login"
                        class="block rounded-md px-3 py-2 font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Login</a>
                    <a href="/register"
                        class="block rounded-md px-3 py-2 font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Register</a>
                </div>
            @endif
        </div>
    </div>
</nav>
