<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- LEFT SIDE -->
            <div class="flex items-center">

                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden sm:flex sm:ml-10 space-x-8">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>
                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="hidden sm:flex sm:items-center space-x-4">

                @auth
                    <!-- Cart Icon with Count -->
                    <div class="relative">
                        <a href="{{ route('cart.index') }}" class="text-xl hover:scale-110 transition">
                            🛒
                        </a>
                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </div>

                    <!-- User Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 bg-white rounded-md hover:text-gray-800 focus:outline-none transition">
                                {{ Auth::user()->name }}

                                <svg class="ml-1 h-4 w-4 fill-current" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                Edit Profile
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Logout
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" 
                       class="text-sm text-gray-700 hover:text-gray-900">
                        Login
                    </a>
                @endauth

            </div>

            <!-- MOBILE HAMBURGER -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- MOBILE MENU -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>
        </div>

        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">

                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">
                        {{ Auth::user()->name }}
                    </div>
                    <div class="font-medium text-sm text-gray-500">
                        {{ Auth::user()->email }}
                    </div>
                </div>

                <div class="mt-3 space-y-1">

                    <!-- Mobile Cart Icon with Count -->
                    <a href="{{ route('cart.index') }}" class="flex items-center">
                        🛒 Cart
                        @if($cartCount > 0)
                            <span class="ml-1 bg-red-600 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <x-responsive-nav-link :href="route('profile.edit')">
                        Profile
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            Log Out
                        </x-responsive-nav-link>
                    </form>

                </div>
            </div>
        @else
            <div class="pt-4 pb-4 border-t border-gray-200 px-4">
                <a href="{{ route('login') }}" class="text-sm text-gray-700">
                    Login
                </a>
            </div>
        @endauth

    </div>
</nav>
