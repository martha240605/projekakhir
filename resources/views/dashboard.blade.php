<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard Pengguna') }}
        </h2>
    </x-slot>

    <div class="flex min-h-screen bg-gray-100">
        {{-- Sidebar --}}
        <aside class="w-64 bg-white border-r border-gray-200 p-6">
            <h2 class="text-xl font-semibold mb-6">Menu</h2>
            <ul class="space-y-4">
                <li>
                    <a href="{{ route('dashboard') }}" class="block text-gray-800 hover:text-blue-600">Beranda</a>
                </li>
                <li>
                    <a href="#" class="block text-gray-800 hover:text-blue-600">Booking Lapangan</a>
                </li>
                <li>
                    <a href="#" class="block text-gray-800 hover:text-blue-600">Riwayat Transaksi</a>
                </li>
            </ul>

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}" class="mt-8">
                @csrf
                <button class="w-full bg-red-500 text-white py-2 rounded hover:bg-red-600">
                    Logout
                </button>
            </form>
        </aside>

        {{-- Konten utama --}}
        <main class="flex-1 p-6">
            <h1 class="text-2xl font-bold mb-4">Selamat datang, {{ Auth::user()->name }}!</h1>
            <p class="text-gray-600 mb-4">Silakan pilih menu di sebelah kiri untuk memulai booking lapangan.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-4 rounded shadow">
                    <img src="{{ asset('images/futsal.jpg') }}" class="w-full h-40 object-cover rounded mb-3" alt="Futsal">
                    <h2 class="text-lg font-semibold">Lapangan Futsal</h2>
                    <p class="text-sm text-gray-600">Jam operasional: 07:00 - 22:00 WIB</p>
                    <a href="#" class="inline-block mt-3 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Booking</a>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <img src="{{ asset('images/badminton.jpg') }}" class="w-full h-40 object-cover rounded mb-3" alt="Badminton">
                    <h2 class="text-lg font-semibold">Lapangan Badminton</h2>
                    <p class="text-sm text-gray-600">Jam operasional: 08:00 - 21:00 WIB</p>
                    <a href="#" class="inline-block mt-3 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Booking</a>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
