@extends('layouts.admin')

@section('title', 'Detail Booking')
@section('header_title', 'Detail Booking')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Detail Booking #{{ $booking->id }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Informasi Booking</h3>
                <p class="text-gray-600 mb-2"><strong class="text-gray-800">Pengguna:</strong> {{ $booking->user->name }}</p>
                <p class="text-gray-600 mb-2"><strong class="text-gray-800">Email Pengguna:</strong> {{ $booking->user->email }}</p>
                <p class="text-gray-600 mb-2"><strong class="text-gray-800">Nama Lapangan:</strong> {{ $booking->field->name }}</p>
                <p class="text-gray-600 mb-2"><strong class="text-gray-800">Tanggal Booking:</strong> {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('l, d F Y') }}</p>
                <p class="text-gray-600 mb-2"><strong class="text-gray-800">Waktu Booking:</strong> {{ $booking->startTimeSlot->start_time->format('H:i') }} - {{ $booking->endTimeSlot->end_time->format('H:i') }}</p>
                <p class="text-gray-600 mb-2"><strong class="text-gray-800">Durasi:</strong> {{ $booking->total_slots }} slot (Total {{ $booking->total_slots }} jam)</p>
                <p class="text-gray-600 mb-2"><strong class="text-gray-800">Total Harga:</strong> Rp{{ number_format($booking->total_price, 0, ',', '.') }}</p>
                <p class="text-gray-600 mb-2"><strong class="text-gray-800">Status:</strong>
                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight">
                        <span aria-hidden="true" class="absolute inset-0 opacity-50 rounded-full
                            @if($booking->status == 'pending') bg-yellow-200 @elseif($booking->status == 'confirmed') bg-green-200 @elseif($booking->status == 'rejected' || $booking->status == 'canceled') bg-red-200 @else bg-gray-200 @endif
                        "></span>
                        <span class="relative capitalize">{{ str_replace('_', ' ', $booking->status) }}</span>
                    </span>
                </p>
                <p class="text-gray-600 mb-2"><strong class="text-gray-800">Catatan Pengguna:</strong> {{ $booking->notes ?? '-' }}</p>
                <p class="text-gray-600 mb-2"><strong class="text-gray-800">Dibuat Pada:</strong> {{ $booking->created_at->translatedFormat('d M Y H:i') }}</p>
                <p class="text-gray-600 mb-2"><strong class="text-gray-800">Terakhir Diperbarui:</strong> {{ $booking->updated_at->translatedFormat('d M Y H:i') }}</p>
            </div>
            <div>
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Bukti Pembayaran:</h3>
                @if($booking->payment_proof)
                    <img src="{{ asset('storage/' . $booking->payment_proof) }}" alt="Bukti Pembayaran" class="max-w-full h-auto rounded-lg shadow-md mb-4">
                    <a href="{{ asset('storage/' . $booking->payment_proof) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Gambar Ukuran Penuh</a>
                @else
                    <p class="text-gray-600">Belum ada bukti pembayaran diunggah.</p>
                @endif
            </div>
        </div>

        <hr class="my-6">

        <h3 class="text-2xl font-bold text-gray-800 mb-4">Aksi Admin</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-800 mb-3">Ubah Status Booking:</h4>
                <form action="{{ route('admin.bookings.update_status', $booking->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
                        <select id="status" name="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('status') border-red-500 @enderror" required>
                            <option value="pending" {{ old('status', $booking->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="pending_review" {{ old('status', $booking->status) == 'pending_review' ? 'selected' : '' }}>Pending Review (Bukti pembayaran diunggah)</option>
                            <option value="confirmed" {{ old('status', $booking->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="rejected" {{ old('status', $booking->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="canceled" {{ old('status', $booking->status) == 'canceled' ? 'selected' : '' }}>Canceled (Dibatalkan Pengguna)</option>
                            <option value="completed" {{ old('status', $booking->status) == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                        </select>
                        @error('status')<p class="text-red-500 text-xs italic">{{ $message }}</p>@enderror
                    </div>
                    <div class="mb-4">
                        <label for="admin_notes" class="block text-gray-700 text-sm font-bold mb-2">Catatan Admin (Opsional):</label>
                        <textarea id="admin_notes" name="admin_notes" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('admin_notes') border-red-500 @enderror">{{ old('admin_notes', $booking->admin_notes) }}</textarea>
                        @error('admin_notes')<p class="text-red-500 text-xs italic">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
                        Update Status
                    </button>
                </form>
            </div>

            <div class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-800 mb-3">Hapus Booking:</h4>
                <p class="text-gray-700 mb-4">Hapus booking ini secara permanen dari sistem.</p>
                <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus booking ini secara permanen?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
                        Hapus Booking
                    </button>
                </form>
            </div>
        </div>

        <div class="mt-8">
            <a href="{{ route('admin.bookings.index') }}" class="text-blue-600 hover:underline flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Booking
            </a>
        </div>
    </div>
@endsection