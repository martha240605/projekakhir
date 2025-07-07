@extends('layouts.app') {{-- Menggunakan layout utama Anda --}}

@section('title', 'Selamat Datang di Arena Kita!')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h2 class="text-3xl font-bold mb-6 text-center">Temukan Lapangan Impianmu!</h2>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Berhasil!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if($fields->isEmpty())
                    <div class="text-center py-10">
                        <p class="text-gray-600 dark:text-gray-400 text-lg">Belum ada lapangan yang tersedia saat ini.</p>
                        <p class="text-gray-500 dark:text-gray-300">Silakan cek kembali nanti atau hubungi admin.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($fields as $field)
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-lg">
                                @if($field->image)
                                    <img src="{{ asset('storage/' . $field->image) }}" alt="{{ $field->name }}" class="w-full h-48 object-cover">
                                @else
                                    <img src="https://via.placeholder.com/400x300?text=Gambar+Lapangan" alt="No Image" class="w-full h-48 object-cover">
                                @endif
                                <div class="p-4">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ $field->name }}</h3>
                                    <p class="text-gray-700 dark:text-gray-300 text-sm mb-2">{{ $field->type }}</p>
                                    <p class="text-gray-700 dark:text-gray-300 text-sm mb-4 line-clamp-3">{{ $field->description ?? 'Tidak ada deskripsi.' }}</p>
                                    <div class="flex justify-between items-center mb-4">
                                        <span class="text-lg font-bold text-lime-600 dark:text-lime-400">
                                            Rp{{ number_format($field->price_per_hour, 0, ',', '.') }}/jam
                                        </span>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            @if($field->status == 'available') bg-green-200 text-green-800 dark:bg-green-700 dark:text-green-100
                                            @elseif($field->status == 'maintenance') bg-red-200 text-red-800 dark:bg-red-700 dark:text-red-100
                                            @else bg-gray-200 text-gray-800 dark:bg-gray-600 dark:text-gray-200 @endif">
                                            {{ ucfirst($field->status) }}
                                        </span>
                                    </div>
                                    <a href="#" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center transition duration-300">
                                        Lihat Detail & Booking
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Jika Anda menggunakan paginasi di controller, tambahkan ini --}}
                {{-- <div class="mt-8">
                    {{ $fields->links() }}
                </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection