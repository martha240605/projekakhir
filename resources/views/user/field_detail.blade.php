@extends('layouts.user')

@section('title', $field->name)

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                @if($field->image)
                    <img src="{{ asset('storage/' . $field->image) }}" alt="{{ $field->name }}" class="w-full h-auto rounded-lg shadow-md object-cover">
                @else
                    <img src="https://via.placeholder.com/600x400?text=No+Image" alt="No Image" class="w-full h-auto rounded-lg shadow-md object-cover">
                @endif
            </div>
            <div>
                <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $field->name }}</h1>
                <p class="text-gray-700 text-lg mb-6">{{ $field->description }}</p>
                <p class="text-gray-800 text-2xl font-bold mb-6">Harga: Rp{{ number_format($field->price_per_hour, 0, ',', '.') }}/jam</p>
                <p class="text-gray-600 mb-4">Tipe: <span class="font-semibold">{{ $field->type ?? 'Tidak Diketahui' }}</span></p>
                <p class="text-gray-600 mb-4">Status: <span class="font-semibold capitalize">{{ $field->status }}</span></p>

                <hr class="my-6">

                <h2 class="text-2xl font-bold text-gray-800 mb-4">Formulir Booking</h2>
                @auth
                    @if($field->status == 'available')
                        <form action="{{ route('user.bookings.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="field_id" value="{{ $field->id }}">

                            <div class="mb-4">
                                <label for="booking_date" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Booking:</label>
                                <input type="date" id="booking_date" name="booking_date"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    min="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="start_time_slot_id" class="block text-gray-700 text-sm font-bold mb-2">Pilih Waktu Mulai:</label>
                                <select id="start_time_slot_id" name="start_time_slot_id"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    required>
                                    <option value="">Pilih Slot Waktu</option>
                                    {{-- Time slots akan dimuat di sini oleh JavaScript --}}
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="end_time_slot_id" class="block text-gray-700 text-sm font-bold mb-2">Pilih Waktu Selesai:</label>
                                <select id="end_time_slot_id" name="end_time_slot_id"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    required>
                                    <option value="">Pilih Slot Waktu</option>
                                    {{-- Time slots akan dimuat di sini oleh JavaScript --}}
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="notes" class="block text-gray-700 text-sm font-bold mb-2">Catatan (Opsional):</label>
                                <textarea id="notes" name="notes" rows="3"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    placeholder="Tambahkan catatan untuk booking Anda..."></textarea>
                            </div>

                            <div class="flex items-center justify-between">
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
                                    Booking Sekarang
                                </button>
                            </div>
                        </form>
                    @else
                        <p class="text-red-600 font-semibold text-lg">Lapangan ini saat ini tidak tersedia untuk dibooking.</p>
                    @endif
                @else
                    <p class="text-gray-600">Anda harus <a href="{{ route('login') }}" class="text-blue-600 hover:underline">login</a> untuk bisa booking lapangan.</p>
                @endauth
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bookingDateInput = document.getElementById('booking_date');
        const startTimeSlotSelect = document.getElementById('start_time_slot_id');
        const endTimeSlotSelect = document.getElementById('end_time_slot_id');
        const fieldId = {{ $field->id }};

        function fetchTimeSlots() {
            const bookingDate = bookingDateInput.value;
            if (!bookingDate) {
                startTimeSlotSelect.innerHTML = '<option value="">Pilih Slot Waktu</option>';
                endTimeSlotSelect.innerHTML = '<option value="">Pilih Slot Waktu</option>';
                return;
            }

            // Ganti URL ini dengan rute API yang akan kamu buat nanti
            // Untuk sementara, kita asumsikan ada route yang mengembalikan semua timeslot
            // Nanti kita akan kembangkan untuk filter timeslot yang tersedia
            fetch(`/api/time-slots?date=${bookingDate}&field_id=${fieldId}`)
                .then(response => response.json())
                .then(data => {
                    let startOptions = '<option value="">Pilih Waktu Mulai</option>';
                    let endOptions = '<option value="">Pilih Waktu Selesai</option>';

                    data.forEach(slot => {
                        // Pastikan slot tersedia atau tidak ada booking lain
                        // Logika ini akan lebih kompleks di backend
                        startOptions += `<option value="${slot.id}">${slot.start_time.substring(0, 5)} - ${slot.end_time.substring(0, 5)}</option>`;
                        endOptions += `<option value="${slot.id}">${slot.start_time.substring(0, 5)} - ${slot.end_time.substring(0, 5)}</option>`;
                    });

                    startTimeSlotSelect.innerHTML = startOptions;
                    endTimeSlotSelect.innerHTML = endOptions;
                })
                .catch(error => {
                    console.error('Error fetching time slots:', error);
                    startTimeSlotSelect.innerHTML = '<option value="">Gagal memuat slot waktu</option>';
                    endTimeSlotSelect.innerHTML = '<option value="">Gagal memuat slot waktu</option>';
                });
        }

        // Fetch time slots when the page loads if a date is already selected (e.g., after validation error)
        if (bookingDateInput.value) {
            fetchTimeSlots();
        }

        // Fetch time slots when the booking date changes
        bookingDateInput.addEventListener('change', fetchTimeSlots);

        // Tambahkan logika validasi sederhana agar waktu selesai tidak kurang dari waktu mulai
        startTimeSlotSelect.addEventListener('change', function() {
            const selectedStartId = this.value;
            // Clear end time selection if start time changes
            endTimeSlotSelect.value = "";
            // Disable options in end time select that are before selected start time
            Array.from(endTimeSlotSelect.options).forEach(option => {
                if (option.value && parseInt(option.value) <= parseInt(selectedStartId)) {
                    option.disabled = true;
                } else {
                    option.disabled = false;
                }
            });
        });
    });
</script>
@endpush