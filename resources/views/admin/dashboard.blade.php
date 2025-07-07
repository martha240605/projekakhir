@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('header_title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6 flex items-center justify-between">
            <div>
                <h3 class="text-gray-600 text-sm font-medium">Total Lapangan</h3>
                <p class="text-3xl font-bold text-gray-900">{{ $totalFields }}</p>
            </div>
            <i class="fas fa-futbol text-5xl text-blue-500 opacity-25"></i>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 flex items-center justify-between">
            <div>
                <h3 class="text-gray-600 text-sm font-medium">Booking Pending</h3>
                <p class="text-3xl font-bold text-gray-900">{{ $pendingBookings }}</p>
            </div>
            <i class="fas fa-hourglass-half text-5xl text-yellow-500 opacity-25"></i>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 flex items-center justify-between">
            <div>
                <h3 class="text-gray-600 text-sm font-medium">Total Pengguna</h3>
                <p class="text-3xl font-bold text-gray-900">{{ $totalUsers }}</p>
            </div>
            <i class="fas fa-users text-5xl text-green-500 opacity-25"></i>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Booking Terbaru</h2>
        @if($latestBookings->isEmpty())
            <p class="text-gray-600">Belum ada booking terbaru.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Booking ID
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Pengguna
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Lapangan
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Tanggal & Waktu
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
                        @foreach($latestBookings as $booking)
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">#{{ $booking->id }}</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ $booking->user->name }}</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ $booking->field->name }}</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d M Y') }}<br>
                                        {{ $booking->startTimeSlot->start_time->format('H:i') }} - {{ $booking->endTimeSlot->end_time->format('H:i') }}
                                    </p>
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
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection