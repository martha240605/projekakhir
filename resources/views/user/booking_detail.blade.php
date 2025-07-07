@extends('layouts.user')

@section('title', 'Detail Booking')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Detail Booking #{{ $booking->id }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
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
                <p class="text-gray-600 mb-2"><strong class="text-gray-800">Catatan dari Anda:</strong> {{ $booking->notes ?? '-' }}</p>
                <p class="text-gray-600 mb-2"><strong class="text-gray-800">Catatan dari Admin:</strong> {{ $booking->admin_notes ?? '-' }}</p>
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

        @if($booking->status == 'pending' || $booking->status == 'pending_review')
            <hr class="my-6">
            <div id="upload-proof" class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Unggah Bukti Pembayaran</h3>
                <p class="text-gray-700 mb-4">Silakan unggah bukti transfer Anda untuk booking ini. Admin akan memverifikasi pembayaran Anda.</p>
                <form action="{{ route('user.bookings.uploadProof', $booking->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="payment_proof" class="block text-gray-700 text-sm font-bold mb-2">Pilih File Bukti Pembayaran (JPG, PNG, GIF, maks 2MB):</label>
                        <input type="file" name="payment_proof" id="payment_proof" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
                        Unggah Bukti Pembayaran
                    </button>
                </form>
            </div>
        @endif

        <div class="mt-8">
            <a href="{{ route('user.bookings.history') }}" class="text-blue-600 hover:underline flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Riwayat Booking
            </a>
        </div>
    </div>
@endsection