@extends('layouts.admin')

@section('title', 'Tambah Lapangan Baru')
@section('header_title', 'Tambah Lapangan')

@section('content')
    <div class="bg-gray-800 shadow-lg rounded-lg p-6 mb-8 text-gray-200">
        <h2 class="text-2xl font-bold text-white mb-6">Tambah Lapangan Baru</h2>

        <form action="{{ route('admin.fields.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-300 text-sm font-bold mb-2">Nama Lapangan:</label>
                <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline bg-gray-700 border-gray-600 placeholder-gray-400" placeholder="Contoh: Lapangan Futsal A" required>
                @error('name')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="type" class="block text-gray-300 text-sm font-bold mb-2">Tipe Lapangan:</label>
                <select name="type" id="type" class="shadow border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline bg-gray-700 border-gray-600" required>
                    <option value="">Pilih Tipe</option>
                    <option value="Futsal">Futsal</option>
                    <option value="Badminton">Badminton</option>
                    <option value="Basket">Basket</option>
                    <option value="Tenis">Tenis</option>
                    <!-- Tambahkan tipe lain jika ada -->
                </select>
                @error('type')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="price_per_hour" class="block text-gray-300 text-sm font-bold mb-2">Harga per Jam:</label>
                <input type="number" name="price_per_hour" id="price_per_hour" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline bg-gray-700 border-gray-600 placeholder-gray-400" placeholder="Contoh: 50000" required min="0">
                @error('price_per_hour')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-300 text-sm font-bold mb-2">Deskripsi:</label>
                <textarea name="description" id="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline bg-gray-700 border-gray-600 placeholder-gray-400" placeholder="Deskripsi singkat tentang lapangan..."></textarea>
                @error('description')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="image" class="block text-gray-300 text-sm font-bold mb-2">Gambar Lapangan:</label>
                <input type="file" name="image" id="image" class="block w-full text-sm text-gray-400
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-lime-500 file:text-white
                    hover:file:bg-lime-600 cursor-pointer"
                    accept="image/*">
                @error('image')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="status" class="block text-gray-300 text-sm font-bold mb-2">Status:</label>
                <select name="status" id="status" class="shadow border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline bg-gray-700 border-gray-600" required>
                    <option value="available">Available</option>
                    <option value="maintenance">Maintenance</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-lime-500 hover:bg-lime-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
                    Simpan Lapangan
                </button>
                <a href="{{ route('admin.fields.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-400 hover:text-gray-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection