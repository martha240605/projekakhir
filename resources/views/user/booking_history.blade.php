@extends('layouts.user')

@section('title', 'Riwayat Booking')

@section('content')
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Riwayat Booking Anda</h1>

    @if($bookings->isEmpty())
        <p class="text-gray-600">Anda belum memiliki riwayat booking.</p>
    @else
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Lapangan
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Tanggal Booking
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Waktu
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Total Harga
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ $booking->field->name }}</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d M Y') }}</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        {{ $booking->startTimeSlot->start_time->format('H:i') }} - {{ $booking->endTimeSlot->end_time->format('H:i') }}
                                    </p>
                                    <p class="text-gray-600 text-xs">({{ $booking->total_slots }} slot)</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight">
                                        <span aria-hidden="true" class="absolute inset-0 opacity-50 rounded-full
                                            @if($booking->status == 'pending') bg-yellow-200 @elseif($booking->status == 'confirmed') bg-green-200 @elseif($booking->status == 'rejected' || $booking->status == 'canceled') bg-red-200 @else bg-gray-200 @endif
                                        "></span>
                                        <span class="relative capitalize">{{ str_replace('_', ' ', $booking->status) }}</span>
                                    </span>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                    <a href="{{ route('user.bookings.show', $booking->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    @if($booking->status == 'pending' || $booking->status == 'pending_review')
                                        <a href="{{ route('user.bookings.show', $booking->id) }}#upload-proof" class="text-purple-600 hover:text-purple-900">
                                            <i class="fas fa-upload"></i> Unggah Bukti
                                        </a>
                                        {{-- Jika ingin user bisa membatalkan booking, uncomment ini --}}
                                        {{-- <form action="{{ route('user.bookings.cancel', $booking->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan booking ini?');">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="text-red-600 hover:text-red-900 ml-3">
                                                <i class="fas fa-times-circle"></i> Batalkan
                                            </button>
                                        </form> --}}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
                {{ $bookings->links() }}
            </div>
        </div>
    @endif
@endsection