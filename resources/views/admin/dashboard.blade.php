@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('header_title', 'Dashboard')

@section('content')
    <div class="space-y-8"> {{-- Menggunakan space-y untuk jarak vertikal antar bagian --}}

        {{-- Bagian Statistik Ringkasan --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Kartu Total Lapangan --}}
            <div class="bg-white rounded-xl shadow-lg p-6 flex items-center justify-between transition-transform transform hover:scale-[1.02] duration-200 ease-in-out border border-gray-100">
                <div>
                    <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Lapangan</h3>
                    <p class="text-4xl font-extrabold text-gray-900 mt-1">{{ $totalFields }}</p>
                </div>
                <i class="fas fa-futbol text-6xl text-blue-400 opacity-20"></i>
            </div>

            {{-- Kartu Booking Pending --}}
            <div class="bg-white rounded-xl shadow-lg p-6 flex items-center justify-between transition-transform transform hover:scale-[1.02] duration-200 ease-in-out border border-gray-100">
                <div>
                    <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Booking Pending</h3>
                    <p class="text-4xl font-extrabold text-gray-900 mt-1">{{ $pendingBookings }}</p>
                </div>
                <i class="fas fa-hourglass-half text-6xl text-yellow-400 opacity-20"></i>
            </div>

            {{-- Kartu Total Pengguna --}}
            <div class="bg-white rounded-xl shadow-lg p-6 flex items-center justify-between transition-transform transform hover:scale-[1.02] duration-200 ease-in-out border border-gray-100">
                <div>
                    <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Pengguna</h3>
                    <p class="text-4xl font-extrabold text-gray-900 mt-1">{{ $totalUsers }}</p>
                </div>
                <i class="fas fa-users text-6xl text-green-400 opacity-20"></i>
            </div>
        </div>

        {{-- Bagian Tabel Booking Terbaru --}}
        <div class="bg-white rounded-xl shadow-lg p-7 border border-gray-100">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Booking Terbaru</h2> {{-- Jarak bawah lebih konsisten --}}
            @if($latestBookings->isEmpty())
                <p class="text-gray-600 text-center py-8">Belum ada booking terbaru yang tersedia.</p> {{-- Pesan di tengah --}}
            @else
                <div class="overflow-x-auto -mx-1"> {{-- Margin negatif untuk padding tabel --}}
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Booking ID
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Pengguna
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Lapangan
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Tanggal & Waktu
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($latestBookings as $booking)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        #{{ $booking->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                        <p class="font-semibold">{{ $booking->user->name }}</p>
                                        <p class="text-gray-500 text-xs">{{ $booking->user->email }}</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                        <p class="font-semibold">{{ $booking->field->name }}</p>
                                        <p class="text-gray-500 text-xs">{{ $booking->field->type }}</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                        <p>{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}</p>
                                        <p class="text-gray-500 text-xs">{{ $booking->startTimeSlot->start_time->format('H:i') }} - {{ $booking->endTimeSlot->end_time->format('H:i') }}</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @php
                                            $statusClass = '';
                                            $statusTextClass = '';
                                            switch ($booking->status) {
                                                case 'pending':
                                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                                    break;
                                                case 'confirmed':
                                                    $statusClass = 'bg-green-100 text-green-800';
                                                    break;
                                                case 'rejected':
                                                case 'canceled':
                                                    $statusClass = 'bg-red-100 text-red-800';
                                                    break;
                                                default:
                                                    $statusClass = 'bg-gray-100 text-gray-800';
                                                    break;
                                            }
                                        @endphp
                                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                            {{ ucwords(str_replace('_', ' ', $booking->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-blue-600 hover:text-blue-900 mr-3 inline-flex items-center">
                                            <i class="fas fa-eye mr-1 text-sm"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection