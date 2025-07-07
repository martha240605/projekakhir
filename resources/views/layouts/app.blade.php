<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-morphism { backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); }
        .animate-float { animation: float 3s ease-in-out infinite; }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .bg-mesh { background: radial-gradient(circle at 20% 50%, rgba(120, 219, 226, 0.1) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(255, 107, 107, 0.1) 0%, transparent 50%), radial-gradient(circle at 40% 80%, rgba(132, 204, 22, 0.1) 0%, transparent 50%); }
        .text-gradient { background: linear-gradient(135deg, #84cc16 0%, #10b981 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-950 text-gray-100 overflow-x-hidden">
    <!-- Background Pattern -->
    <div class="fixed inset-0 bg-mesh opacity-50 pointer-events-none"></div>
    
    <div class="min-h-screen flex flex-col relative">
        <!-- Modern Navigation -->
        <nav x-data="{ open: false }" class="sticky top-0 z-50 glass-morphism bg-gray-900/80 border-b border-gray-700/50 shadow-2xl">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <!-- Logo Section -->
                    <div class="flex items-center">
                        <div class="shrink-0 flex items-center group">
                            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                                <div class="relative">
                                    <div class="w-12 h-12 bg-gradient-to-br from-lime-400 to-emerald-500 rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-all duration-300 shadow-lg group-hover:shadow-lime-500/25">
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                    </div>
                                    <div class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full animate-pulse"></div>
                                </div>
                                <div class="hidden sm:block">
                                    <h1 class="text-xl font-bold text-gradient">SportField</h1>
                                    <p class="text-xs text-gray-400">Booking System</p>
                                </div>
                            </a>
                        </div>

                        <!-- Desktop Navigation -->
                        <div class="hidden lg:flex lg:ml-10 lg:space-x-1">
                            <a href="{{ route('dashboard') }}" class="group flex items-center px-4 py-2 text-sm font-medium text-gray-300 hover:text-white rounded-xl hover:bg-white/10 transition-all duration-300">
                                <svg class="w-5 h-5 mr-2 group-hover:text-lime-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Dashboard
                            </a>
                            <a href="#" class="group flex items-center px-4 py-2 text-sm font-medium text-gray-300 hover:text-white rounded-xl hover:bg-white/10 transition-all duration-300">
                                <svg class="w-5 h-5 mr-2 group-hover:text-lime-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                Lihat Lapangan
                            </a>
                            <a href="#" class="group flex items-center px-4 py-2 text-sm font-medium text-gray-300 hover:text-white rounded-xl hover:bg-white/10 transition-all duration-300">
                                <svg class="w-5 h-5 mr-2 group-hover:text-lime-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Riwayat Booking
                            </a>
                        </div>
                    </div>

                    <!-- Desktop User Menu -->
                    <div class="hidden lg:flex lg:items-center lg:space-x-4">
                        @auth
                            <!-- Notification Bell -->
                            <button class="relative p-2 text-gray-400 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5-5-5h5zm-7.5-1.5l-1.5-1.5 3.5-3.5 3.5 3.5-1.5 1.5H7.5zm0 0v-6c0-1.1-.9-2-2-2s-2 .9-2 2v6h4z"></path>
                                </svg>
                                <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full"></span>
                            </button>

                            <!-- User Dropdown -->
                            <x-dropdown align="right" width="64">
                                <x-slot name="trigger">
                                    <button class="flex items-center space-x-3 px-4 py-2 text-sm font-medium text-gray-300 hover:text-white rounded-xl hover:bg-white/10 transition-all duration-300">
                                        <div class="w-8 h-8 bg-gradient-to-br from-lime-400 to-emerald-500 rounded-full flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                        </div>
                                        <div class="text-left">
                                            <div class="font-medium">{{ Auth::user()->name }}</div>
                                            <div class="text-xs text-gray-400">{{ Auth::user()->email }}</div>
                                        </div>
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="p-2 space-y-1">
                                        <x-dropdown-link :href="route('user.profile.edit')" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-white/10 rounded-lg transition-all duration-300">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            Profile
                                        </x-dropdown-link>
                                        
                                        <hr class="border-gray-700 my-2">
                                        
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')"
                                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                                    class="flex items-center px-4 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-lg transition-all duration-300">
                                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                </svg>
                                                Log Out
                                            </x-dropdown-link>
                                        </form>
                                    </div>
                                </x-slot>
                            </x-dropdown>
                        @endauth
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="lg:hidden flex items-center">
                        <button @click="open = ! open" class="p-2 text-gray-400 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-300">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div :class="{'block': open, 'hidden': ! open}" class="lg:hidden glass-morphism bg-gray-900/95 border-t border-gray-700/50">
                <div class="px-4 pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center px-4 py-3 text-base font-medium text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-300">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </x-responsive-nav-link>
                    
                    <x-responsive-nav-link :href="route('user.home')" :active="request()->routeIs('user.home')" class="flex items-center px-4 py-3 text-base font-medium text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-300">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Lihat Lapangan
                    </x-responsive-nav-link>
                    
                    <x-responsive-nav-link :href="route('user.bookings.history')" :active="request()->routeIs('user.bookings.history')" class="flex items-center px-4 py-3 text-base font-medium text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-300">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Riwayat Booking
                    </x-responsive-nav-link>
                </div>

                @auth
                    <div class="pt-4 pb-3 border-t border-gray-700/50">
                        <div class="flex items-center px-4 mb-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-lime-400 to-emerald-500 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                                <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                        
                        <div class="space-y-1 px-4">
                            <x-responsive-nav-link :href="route('user.profile.edit')" class="flex items-center px-4 py-3 text-base font-medium text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-300">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Profile
                            </x-responsive-nav-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-responsive-nav-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="flex items-center px-4 py-3 text-base font-medium text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-xl transition-all duration-300">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Log Out
                                </x-responsive-nav-link>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </nav>

        <!-- Page Header -->
        @if (isset($header))
            <header class="glass-morphism bg-gray-800/50 shadow-2xl border-b border-gray-700/50">
                <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Main Content -->
        <main class="flex-1 relative">
            <div class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>

        <!-- Modern Toast Notifications -->
        @if (session('success'))
            <div id="success-toast" class="fixed bottom-6 right-6 z-50 max-w-sm w-full">
                <div class="glass-morphism bg-green-500/20 border border-green-500/30 text-green-100 p-4 rounded-2xl shadow-2xl backdrop-blur-xl animate-float">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium">Berhasil!</p>
                            <p class="text-sm text-green-200">{{ session('success') }}</p>
                        </div>
                        <button onclick="document.getElementById('success-toast').remove()" class="ml-4 text-green-200 hover:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div id="error-toast" class="fixed bottom-6 right-6 z-50 max-w-sm w-full">
                <div class="glass-morphism bg-red-500/20 border border-red-500/30 text-red-100 p-4 rounded-2xl shadow-2xl backdrop-blur-xl animate-float">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium">Terjadi Kesalahan!</p>
                            <p class="text-sm text-red-200">{{ session('error') }}</p>
                        </div>
                        <button onclick="document.getElementById('error-toast').remove()" class="ml-4 text-red-200 hover:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        // Auto-hide toast notifications after 5 seconds
        setTimeout(() => {
            const successToast = document.getElementById('success-toast');
            const errorToast = document.getElementById('error-toast');
            if (successToast) successToast.remove();
            if (errorToast) errorToast.remove();
        }, 5000);
    </script>
</body>
</html>