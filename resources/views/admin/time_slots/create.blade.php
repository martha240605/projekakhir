@extends('layouts.admin')

@section('title', 'Tambah Slot Waktu')
@section('header_title', 'Tambah Slot Waktu Baru')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Slot Waktu Baru</h2>

        <form action="{{ route('admin.time-slots.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="start_time" class="block text-gray-700 text-sm font-bold mb-2">Waktu Mulai:</label>
                <input type="time" id="start_time" name="start_time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('start_time') border-red-500 @enderror" value="{{ old('start_time') }}" required>
                @error('start_time')<p class="text-red-500 text-xs italic">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label for="end_time" class="block text-gray-700 text-sm font-bold mb-2">Waktu Selesai:</label>
                <input type="time" id="end_time" name="end_time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('end_time') border-red-500 @enderror" value="{{ old('end_time') }}" required>
                @error('end_time')<p class="text-red-500 text-xs italic">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Harga per Slot (Opsional):</label>
                <input type="number" id="price" name="price" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('price') border-red-500 @enderror" value="{{ old('price') }}" step="any">
                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika ingin menggunakan harga lapangan per jam.</p>
                @error('price')<p class="text-red-500 text-xs italic">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label for="is_available" class="block text-gray-700 text-sm font-bold mb-2">Tersedia:</label>
                <select id="is_available" name="is_available" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('is_available') border-red-500 @enderror" required>
                    <option value="1" {{ old('is_available') == '1' ? 'selected' : '' }}>Ya</option>
                    <option value="0" {{ old('is_available') == '0' ? 'selected' : '' }}>Tidak</option>
                </select>
                @error('is_available')<p class="text-red-500 text-xs italic">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
                    <i class="fas fa-save mr-2"></i> Simpan Slot
                </button>
                <a href="{{ route('admin.time-slots.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-600 hover:text-gray-800">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection