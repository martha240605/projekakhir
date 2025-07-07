<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-lime-400 leading-tight"> {{ __('Dashboard Pengguna') }}
        </h2>
    </x-slot>

    {{-- Layout Utama Dashboard User --}}
    <div class="flex min-h-screen bg-gray-950 text-gray-200">

        {{-- Sidebar --}}
        <aside class="w-64 bg-gray-900 border-r border-gray-800 p-6 shadow-lg">
            <h2 class="text-xl font-semibold mb-6 text-white">Menu</h2>
            <ul class="space-y-4">
                <li>
                    {{-- Beranda: Kembali ke dashboard ini --}}
                    <a href="{{ route('dashboard') }}" class="block text-gray-300 hover:text-lime-400 transition duration-150 ease-in-out">Beranda</a>
                </li>
                <li>
                    {{-- Link ke halaman ini sendiri, atau halaman daftar booking jika ada --}}
                    <a href="{{ route('dashboard') }}" class="block text-gray-300 hover:text-lime-400 transition duration-150 ease-in-out">Booking Lapangan</a>
                </li>
                <li>
                    {{-- Link ke riwayat transaksi user --}}
                    <a href="#" class="block text-gray-300 hover:text-lime-400 transition duration-150 ease-in-out">Riwayat Transaksi</a>
                </li>
            </ul>

            {{-- Form Logout --}}
            <form method="POST" action="{{ route('logout') }}" class="mt-8">
                @csrf
                <button class="w-full bg-red-700 text-white py-2 rounded hover:bg-red-600 transition duration-150 ease-in-out"> Logout
                </button>
            </form>
        </aside>

        {{-- Konten Utama Dashboard --}}
        <main class="flex-1 p-6">
            <h1 class="text-2xl font-bold mb-4 text-white">Selamat datang, {{ Auth::user()->name }}!</h1>
            <p class="text-gray-400 mb-6">Silakan pilih menu di sebelah kiri untuk memulai booking lapangan.</p>

            <h2 class="text-xl font-bold mb-4 text-white">Lapangan Tersedia:</h2>

            @if($fields->isEmpty())
                {{-- Pesan jika tidak ada lapangan --}}
                <div class="text-center py-10">
                    <p class="text-gray-600 dark:text-gray-400 text-lg">Belum ada lapangan yang tersedia saat ini.</p>
                    <p class="text-gray-500 dark:text-gray-300">Silakan cek kembali nanti atau hubungi admin.</p>
                </div>
            @else
                {{-- Grid untuk menampilkan kartu lapangan --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($fields as $field)
                        {{-- Kartu Lapangan Dinamis --}}
                        <div class="bg-gray-800 p-5 rounded-lg shadow-xl border border-gray-700 transform hover:scale-105 transition-transform duration-200">
                            @if($field->image)
                                <img src="{{ asset('storage/' . $field->image) }}" class="w-full h-40 object-cover rounded-lg mb-4" alt="{{ $field->name }}">
                            @else
                                <img src="https://via.placeholder.com/400x300?text=No+Image" class="w-full h-40 object-cover rounded-lg mb-4" alt="No Image">
                            @endif
                            <h2 class="text-xl font-semibold mb-2 text-white">{{ $field->name }}</h2>
                            <p class="text-sm text-gray-400 mb-1">Tipe: {{ $field->type }}</p>
                            <p class="text-sm text-gray-400 mb-4 line-clamp-3">{{ $field->description ?? 'Tidak ada deskripsi.' }}</p>
                            <p class="text-lg font-bold text-lime-400 mb-4">Rp{{ number_format($field->price_per_hour, 0, ',', '.') }}/jam</p>

                            {{-- Status Lapangan --}}
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($field->status == 'available') bg-green-700 text-green-100
                                @elseif($field->status == 'maintenance') bg-red-700 text-red-100
                                @else bg-gray-600 text-gray-200 @endif">
                                {{ ucfirst($field->status) }}
                            </span>

                            {{-- Tombol Booking (sementara masih #, perlu dihubungkan ke rute booking) --}}
                            <a href="#" class="inline-block mt-3 px-5 py-2 bg-lime-500 text-white rounded-lg hover:bg-lime-600 transition duration-150 ease-in-out font-semibold">Booking</a>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Jika Anda menggunakan paginasi di controller, tambahkan ini: --}}
            {{-- <div class="mt-8">
                {{ $fields->links() }}
            </div> --}}

        </main>
    </div>
</x-app-layout>