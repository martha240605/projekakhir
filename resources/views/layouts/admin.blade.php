<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100"> {{-- Tambahkan h-full di html --}}
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased h-full flex flex-col"> {{-- Tambahkan h-full dan flex flex-col di body --}}

    {{-- Main Container (Mengisi Seluruh Tinggi Layar) --}}
    <div class="min-h-screen bg-gray-100 flex flex-col">

        {{-- Header (Top Navbar/Bar) - TIDAK BERGERAK --}}
        <header class="bg-white shadow flex-shrink-0">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        @yield('header_title', 'Dashboard')
                    </h2>
                    {{-- Dropdown Pengguna Breeze --}}
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('user.profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </div>
        </header>

        {{-- Konten Utama Halaman (Sidebar + Content Area) --}}
        <div class="flex flex-1 overflow-hidden"> {{-- flex-1 agar mengambil sisa tinggi, overflow-hidden agar scroll ditangani di dalamnya --}}

            {{-- Sidebar Admin - TIDAK BERGERAK --}}
            <aside class="w-64 bg-gray-800 text-white flex-shrink-0 overflow-y-auto"> {{-- flex-shrink-0 agar ukuran tetap, overflow-y-auto jika isi sidebar panjang --}}
                <div class="p-4 border-b border-gray-700">
                    <h1 class="text-2xl font-bold">Admin Panel</h1>
                </div>
                <nav class="mt-5">
                    <a href="{{ route('admin.dashboard') }}" class="block py-2 px-4 text-gray-300 hover:bg-gray-700 hover:text-white transition duration-200">
                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.fields.index') }}" class="block py-2 px-4 text-gray-300 hover:bg-gray-700 hover:text-white transition duration-200">
                        <i class="fas fa-futbol mr-2"></i> Manajemen Lapangan
                    </a>
                    <a href="{{ route('admin.bookings.index') }}" class="block py-2 px-4 text-gray-300 hover:bg-gray-700 hover:text-white transition duration-200">
                        <i class="fas fa-book mr-2"></i> Manajemen Booking
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="block py-2 px-4 text-gray-300 hover:bg-gray-700 hover:text-white transition duration-200">
                        <i class="fas fa-users mr-2"></i> Manajemen Pengguna
                    </a>
                    {{-- Tambahkan link sidebar lainnya --}}
                </nav>
            </aside>

            {{-- Area Konten Yang Bisa Di-scroll --}}
            <main class="flex-1 p-6 overflow-y-auto"> {{-- flex-1 mengambil sisa lebar, p-6 padding, overflow-y-auto agar konten bisa di-scroll --}}
                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>

        {{-- Footer - TIDAK BERGERAK --}}
        <footer class="bg-gray-800 text-gray-400 text-center py-4 text-sm flex-shrink-0">
            &copy; {{ date('Y') }} {{ config('app.name', 'Your App') }}. All rights reserved.
        </footer>
    </div>

</body>
</html>