@extends('layouts.admin')

@section('title', 'Edit Lapangan')
@section('header_title', 'Edit Lapangan')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Lapangan: {{ $field->name }}</h2>

        <form action="{{ route('admin.fields.update', $field->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Lapangan:</label>
                <input type="text" id="name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" value="{{ old('name', $field->name) }}" required>
                @error('name')<p class="text-red-500 text-xs italic">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Tipe Lapangan (Contoh: Futsal, Basket, Bulutangkis):</label>
                <input type="text" id="type" name="type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('type') border-red-500 @enderror" value="{{ old('type', $field->type) }}">
                @error('type')<p class="text-red-500 text-xs italic">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi:</label>
                <textarea id="description" name="description" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror">{{ old('description', $field->description) }}</textarea>
                @error('description')<p class="text-red-500 text-xs italic">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label for="price_per_hour" class="block text-gray-700 text-sm font-bold mb-2">Harga Per Jam:</label>
                <input type="number" id="price_per_hour" name="price_per_hour" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('price_per_hour') border-red-500 @enderror" value="{{ old('price_per_hour', $field->price_per_hour) }}" step="any" required>
                @error('price_per_hour')<p class="text-red-500 text-xs italic">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Gambar Lapangan:</label>
                @if($field->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $field->image) }}" alt="Current Image" class="w-32 h-24 object-cover rounded-md">
                        <p class="text-xs text-gray-500 mt-1">Gambar saat ini.</p>
                    </div>
                @endif
                <input type="file" id="image" name="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('image') border-red-500 @enderror">
                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                @error('image')<p class="text-red-500 text-xs italic">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
                <select id="status" name="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('status') border-red-500 @enderror" required>
                    <option value="available" {{ old('status', $field->status) == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="maintenance" {{ old('status', $field->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
                @error('status')<p class="text-red-500 text-xs italic">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
                    <i class="fas fa-save mr-2"></i> Update Lapangan
                </button>
                <a href="{{ route('admin.fields.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-600 hover:text-gray-800">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection