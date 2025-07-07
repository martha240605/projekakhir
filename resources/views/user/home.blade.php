@extends('layouts.user')

@section('title', 'Beranda')

@section('content')
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Daftar Lapangan Tersedia</h1>

    @if($fields->isEmpty())
        <p class="text-gray-600">Belum ada lapangan yang terdaftar.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($fields as $field)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transform transition-transform hover:scale-105 duration-300">
                    @if($field->image)
                        <img src="{{ asset('storage/' . $field->image) }}" alt="{{ $field->name }}" class="w-full h-48 object-cover">
                    @else
                        <img src="https://via.placeholder.com/400x200?text=No+Image" alt="No Image" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $field->name }}</h2>
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($field->description, 100) }}</p>
                        <p class="text-gray-800 font-bold mb-4">Harga: Rp{{ number_format($field->price_per_hour, 0, ',', '.') }}/jam</p>
                        <div class="flex justify-end">
                            <a href="{{ route('user.fields.show', $field->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition duration-300">
                                Lihat Detail & Booking
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $fields->links() }}
        </div>
    @endif
@endsection