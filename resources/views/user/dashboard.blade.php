<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-transparent bg-gradient-to-r from-lime-400 to-emerald-400 bg-clip-text leading-tight">
            {{ __('Dashboard Pengguna') }}
        </h2>
    </x-slot>

    {{-- Layout Utama Dashboard --}}
    <div class="flex min-h-screen bg-gradient-to-br from-gray-950 via-gray-900 to-gray-950 text-gray-100">

        {{-- Sidebar dengan Glassmorphism --}}
        <aside class="w-72 bg-gray-900/60 backdrop-blur-xl border-r border-gray-700/50 p-6 shadow-2xl">
            <div class="flex items-center mb-8">
                <div class="w-10 h-10 bg-gradient-to-br from-lime-400 to-emerald-500 rounded-xl flex items-center justify-center mr-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-white">Menu</h2>
            </div>
            
            <nav class="space-y-3">
                <a href="{{ route('dashboard') }}" class="group flex items-center p-3 rounded-xl text-gray-300 hover:text-white hover:bg-gradient-to-r hover:from-lime-500/20 hover:to-emerald-500/20 transition-all duration-300 border border-transparent hover:border-lime-500/30">
                    <svg class="w-5 h-5 mr-3 group-hover:text-lime-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="font-medium">Beranda</span>
                </a>
                
                <a href="{{ route('dashboard') }}" class="group flex items-center p-3 rounded-xl text-gray-300 hover:text-white hover:bg-gradient-to-r hover:from-lime-500/20 hover:to-emerald-500/20 transition-all duration-300 border border-transparent hover:border-lime-500/30">
                    <svg class="w-5 h-5 mr-3 group-hover:text-lime-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="font-medium">Booking Lapangan</span>
                </a>
                
                <a href="#" class="group flex items-center p-3 rounded-xl text-gray-300 hover:text-white hover:bg-gradient-to-r hover:from-lime-500/20 hover:to-emerald-500/20 transition-all duration-300 border border-transparent hover:border-lime-500/30">
                    <svg class="w-5 h-5 mr-3 group-hover:text-lime-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="font-medium">Riwayat Transaksi</span>
                </a>
            </nav>

            {{-- Form Logout dengan Design Modern --}}
            <form method="POST" action="{{ route('logout') }}" class="mt-auto pt-8">
                @csrf
                <button class="w-full group relative overflow-hidden bg-gradient-to-r from-red-600 to-red-700 text-white py-3 px-4 rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-300 font-medium shadow-lg hover:shadow-red-500/25">
                    <span class="relative z-10 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-red-700 to-red-800 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
                </button>
            </form>
        </aside>

        {{-- Konten Utama Dashboard --}}
        <main class="flex-1 p-8 space-y-8">
            {{-- Header Welcome dengan Gradient --}}
            <div class="bg-gradient-to-r from-gray-800/50 to-gray-900/50 backdrop-blur-sm rounded-2xl p-8 border border-gray-700/50 shadow-2xl">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-transparent bg-gradient-to-r from-white to-gray-300 bg-clip-text mb-2">
                            Selamat datang, {{ Auth::user()->name }}!
                        </h1>
                        <p class="text-gray-400 text-lg">Temukan dan booking lapangan impian Anda dengan mudah</p>
                    </div>
                    <div class="hidden md:block">
                        <div class="w-20 h-20 bg-gradient-to-br from-lime-400 to-emerald-500 rounded-2xl flex items-center justify-center">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section Header --}}
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <svg class="w-8 h-8 mr-3 text-lime-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Lapangan Tersedia
                </h2>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-sm text-gray-400">Live Update</span>
                </div>
            </div>

            @if($fields->isEmpty())
                {{-- Empty State dengan Design Modern --}}
                <div class="text-center py-20">
                    <div class="w-24 h-24 bg-gradient-to-br from-gray-700 to-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">Belum Ada Lapangan</h3>
                    <p class="text-gray-400 text-lg max-w-md mx-auto">
                        Saat ini belum ada lapangan yang tersedia. Silakan cek kembali nanti atau hubungi admin untuk informasi lebih lanjut.
                    </p>
                </div>
            @else
                {{-- Grid Cards dengan Design Modern --}}
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                    @foreach($fields as $field)
                        <div class="group relative bg-gradient-to-br from-gray-800/80 to-gray-900/80 backdrop-blur-sm rounded-2xl shadow-2xl border border-gray-700/50 overflow-hidden hover:shadow-lime-500/20 transition-all duration-500 hover:scale-105 hover:border-lime-500/30">
                            {{-- Image Container --}}
                            <div class="relative overflow-hidden">
                                @if($field->image)
                                    <img src="{{ asset('storage/' . $field->image) }}" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $field->name }}">
                                @else
                                    <div class="w-full h-48 bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                {{-- Status Badge --}}
                                <div class="absolute top-4 right-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold backdrop-blur-sm border
                                        @if($field->status == 'available') bg-green-500/20 text-green-300 border-green-500/30
                                        @elseif($field->status == 'maintenance') bg-red-500/20 text-red-300 border-red-500/30
                                        @else bg-gray-500/20 text-gray-300 border-gray-500/30 @endif">
                                        {{ ucfirst($field->status) }}
                                    </span>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-white mb-2 group-hover:text-lime-400 transition-colors">
                                    {{ $field->name }}
                                </h3>
                                
                                <div class="flex items-center mb-3">
                                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-400">{{ $field->type }}</span>
                                </div>
                                
                                <p class="text-gray-400 text-sm mb-4 line-clamp-2">
                                    {{ $field->description ?? 'Deskripsi tidak tersedia.' }}
                                </p>

                                {{-- Price --}}
                                <div class="flex items-center justify-between mb-6">
                                    <div class="text-2xl font-bold text-transparent bg-gradient-to-r from-lime-400 to-emerald-400 bg-clip-text">
                                        Rp{{ number_format($field->price_per_hour, 0, ',', '.') }}
                                    </div>
                                    <span class="text-sm text-gray-400">/jam</span>
                                </div>

                                {{-- Action Button --}}
                                <a href="#" class="block w-full text-center bg-gradient-to-r from-lime-500 to-emerald-500 text-white py-3 px-6 rounded-xl hover:from-lime-600 hover:to-emerald-600 transition-all duration-300 font-semibold shadow-lg hover:shadow-lime-500/25 transform hover:scale-105">
                                    <span class="flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Booking Sekarang
                                    </span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Pagination (if needed) --}}
            {{-- <div class="flex justify-center mt-12">
                {{ $fields->links() }}
            </div> --}}

        </main>
    </div>
</x-app-layout>