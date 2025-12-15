<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Blogify') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="min-h-screen flex flex-col">
            <!-- Navigation -->
            <nav x-data="{ open: false }" class="bg-blue-600 shadow-lg fixed w-full top-0 z-50" style="background-color: #2563eb;">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <!-- Left spacer for centering -->
                        <div class="flex-1"></div>
                        
                        <!-- Center: Navigation Links -->
                        <div class="flex items-center justify-center space-x-8">
                            <a href="/" class="text-base font-medium text-white hover:text-blue-100 transition px-2" style="color: white !important;">
                                Home
                            </a>
                            <a href="/posts" class="text-base font-medium text-white hover:text-blue-100 transition px-2" style="color: white !important;">
                                Posts
                            </a>
                            <a href="/faq" class="text-base font-medium text-white hover:text-blue-100 transition px-2" style="color: white !important;">
                                FAQ
                            </a>
                            <a href="/contact" class="text-base font-medium text-white hover:text-blue-100 transition px-2" style="color: white !important;">
                                Contact
                            </a>
                        </div>

                        <!-- Right Side: Auth Links -->
                        <div class="flex items-center justify-end flex-1 space-x-4">
                            @auth
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.posts.index') }}" class="text-base font-medium text-white hover:text-blue-100 transition px-2" style="color: white !important;">
                                        Admin Panel
                                    </a>
                                @endif
                                <a href="{{ route('dashboard') }}" class="text-base font-medium text-white hover:text-blue-100 transition px-2" style="color: white !important;">
                                    Dashboard
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-base font-medium text-white hover:text-blue-100 transition px-2" style="color: white !important; background: none; border: none; cursor: pointer;">
                                        Logout
                                    </button>
                                </form>
                            @else
                                <a href="/login" class="text-base font-medium text-white hover:text-blue-100 transition px-2" style="color: white !important;">
                                    Login
                                </a>
                                @if (Route::has('register'))
                                    <a href="/register" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md text-base font-medium text-blue-600 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white transition ml-2" style="background-color: white !important; color: #2563eb !important;">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Mobile menu -->
                <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden border-t border-blue-500">
                    <div class="px-2 pt-2 pb-3 space-y-1">
                        <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-blue-100 hover:bg-blue-700 {{ request()->routeIs('home') ? 'bg-blue-700 text-white' : '' }}">
                            Home
                        </a>
                        <a href="{{ route('posts.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-blue-100 hover:bg-blue-700 {{ request()->routeIs('posts.*') ? 'bg-blue-700 text-white' : '' }}">
                            Posts
                        </a>
                        <a href="{{ route('faq.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-blue-100 hover:bg-blue-700 {{ request()->routeIs('faq.*') ? 'bg-blue-700 text-white' : '' }}">
                            FAQ
                        </a>
                        <a href="{{ route('contact.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-blue-100 hover:bg-blue-700 {{ request()->routeIs('contact.*') ? 'bg-blue-700 text-white' : '' }}">
                            Contact
                        </a>
                    </div>

                    <div class="pt-4 pb-3 border-t border-blue-500">
                        @auth
                            <div class="px-2 space-y-1">
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.posts.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-blue-100 hover:bg-blue-700">
                                        Admin Panel
                                    </a>
                                @endif
                                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-blue-100 hover:bg-blue-700">
                                    Dashboard
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-white hover:text-blue-100 hover:bg-blue-700">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="px-2 space-y-1">
                                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-blue-100 hover:bg-blue-700">
                                    Login
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-blue-100 hover:bg-blue-700">
                                        Register
                                    </a>
                                @endif
                            </div>
                        @endauth
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="flex-1 pt-16" style="padding-top: 4rem !important; margin-top: 0 !important;">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
