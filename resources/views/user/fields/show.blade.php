@extends('layouts.user') {{-- Pastikan layout 'user' ini ada dan diatur dengan baik --}}

@section('title', $field->name)

@section('content')
    <div class="container mx-auto px-4 py-8"> {{-- Kontainer utama dengan padding --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-8 mb-8 border border-gray-100 dark:border-gray-700"> {{-- Kartu utama dengan rounded-xl dan shadow-xl --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-start"> {{-- Gap lebih besar dan align items-start --}}
                {{-- Kolom Gambar --}}
                <div class="flex justify-center items-center h-full"> {{-- Agar gambar di tengah vertikal --}}
                    @if($field->image)
                        <img src="{{ asset('storage/' . $field->image) }}" alt="{{ $field->name }}"
                             class="w-full h-96 object-cover rounded-lg shadow-lg transform transition-transform duration-300 hover:scale-[1.01] border border-gray-200 dark:border-gray-600">
                    @else
                        <img src="https://via.placeholder.com/600x400?text=No+Image+Available" alt="No Image"
                             class="w-full h-96 object-cover bg-gray-200 dark:bg-gray-600 rounded-lg shadow-lg">
                    @endif
                </div>

                {{-- Kolom Detail dan Formulir Booking --}}
                <div>
                    <h1 class="text-4xl font-extrabold text-gray-900 dark:text-gray-100 mb-3">{{ $field->name }}</h1>
                    <p class="text-gray-700 dark:text-gray-300 text-lg mb-5 leading-relaxed">{{ $field->description ?? 'Deskripsi lapangan ini belum tersedia.' }}</p>

                    <div class="flex items-baseline mb-6">
                        <span class="text-green-600 dark:text-green-400 text-3xl font-bold mr-2">
                            Rp{{ number_format($field->price_per_hour, 0, ',', '.') }}
                        </span>
                        <span class="text-gray-600 dark:text-gray-400 text-lg">/jam</span>
                    </div>

                    <p class="text-gray-600 dark:text-gray-400 mb-3">
                        <span class="font-semibold text-gray-700 dark:text-gray-300">Tipe:</span>
                        <span class="capitalize">{{ $field->type ?? 'Tidak Diketahui' }}</span>
                    </p>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        <span class="font-semibold text-gray-700 dark:text-gray-300">Status:</span>
                        <span class="capitalize
                            @if($field->status == 'available') text-green-500 @elseif($field->status == 'maintenance') text-red-500 @else text-yellow-500 @endif
                        ">{{ $field->status }}</span>
                    </p>

                    <hr class="my-8 border-gray-200 dark:border-gray-700">

                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Formulir Booking</h2>
                    @auth
                        @if($field->status == 'available')
                            <form action="{{ route('user.bookings.store') }}" method="POST" class="space-y-6"> {{-- Tambahkan space-y untuk jarak antar elemen form --}}
                                @csrf
                                <input type="hidden" name="field_id" value="{{ $field->id }}">

                                <div>
                                    <label for="booking_date" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Tanggal Booking:</label>
                                    <input type="date" id="booking_date" name="booking_date"
                                           class="form-input block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                           min="{{ date('Y-m-d') }}" required>
                                    @error('booking_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="start_time_slot_id" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Pilih Waktu Mulai:</label>
                                    <select id="start_time_slot_id" name="start_time_slot_id"
                                            class="form-select block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                            required>
                                        <option value="">Pilih Slot Waktu</option>
                                        {{-- Time slots akan dimuat di sini oleh JavaScript --}}
                                    </select>
                                    @error('start_time_slot_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="end_time_slot_id" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Pilih Waktu Selesai:</label>
                                    <select id="end_time_slot_id" name="end_time_slot_id"
                                            class="form-select block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                            required>
                                        <option value="">Pilih Slot Waktu</option>
                                        {{-- Time slots akan dimuat di sini oleh JavaScript --}}
                                    </select>
                                    @error('end_time_slot_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="notes" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Catatan (Opsional):</label>
                                    <textarea id="notes" name="notes" rows="4"
                                              class="form-textarea block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                              placeholder="Tambahkan catatan untuk booking Anda..."></textarea>
                                    @error('notes') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="flex items-center justify-end"> {{-- Tombol di kanan --}}
                                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        <i class="fas fa-calendar-check mr-2"></i> Booking Sekarang
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="bg-red-50 dark:bg-red-900/20 p-6 rounded-lg text-red-800 dark:text-red-200 text-center border border-red-200 dark:border-red-900">
                                <p class="text-lg font-semibold mb-2">
                                    <i class="fas fa-exclamation-triangle mr-2"></i> Lapangan ini saat ini tidak tersedia untuk dibooking.
                                </p>
                                <p class="text-sm">Status: <span class="capitalize">{{ $field->status }}</span></p>
                            </div>
                        @endif
                    @else
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-6 rounded-lg text-blue-800 dark:text-blue-200 text-center border border-blue-200 dark:border-blue-900">
                            <p class="text-lg font-semibold mb-2">
                                Anda harus <a href="{{ route('login') }}" class="text-blue-700 dark:text-blue-300 hover:underline font-bold">login</a> untuk bisa booking lapangan.
                            </p>
                            <p class="text-sm">Belum punya akun? <a href="{{ route('register') }}" class="text-blue-700 dark:text-blue-300 hover:underline font-bold">Daftar di sini</a>.</p>
                        </div>
                    @endauth
                </div>
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
                startTimeSlotSelect.innerHTML = '<option value="">Pilih Waktu Mulai</option>';
                endTimeSlotSelect.innerHTML = '<option value="">Pilih Waktu Selesai</option>';
                return;
            }

            // PENTING: Anda perlu membuat API endpoint ini di backend Anda.
            // Contoh rute di routes/api.php:
            // Route::get('/time-slots', [App\Http\Controllers\Api\TimeSlotController::class, 'getAvailableTimeSlots']);
            fetch(`/api/time-slots?date=${bookingDate}&field_id=${fieldId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    let startOptions = '<option value="">Pilih Waktu Mulai</option>';
                    let endOptions = '<option value="">Pilih Waktu Selesai</option>';

                    data.forEach(slot => {
                        const optionText = `${slot.start_time.substring(0, 5)} - ${slot.end_time.substring(0, 5)}`;
                        startOptions += `<option value="${slot.id}">${optionText}</option>`;
                        endOptions += `<option value="${slot.id}">${optionText}</option>`;
                    });

                    startTimeSlotSelect.innerHTML = startOptions;
                    endTimeSlotSelect.innerHTML = endOptions;

                    // Mengatur ulang pilihan waktu selesai jika waktu mulai sudah ada
                    const currentStartTime = startTimeSlotSelect.value;
                    if (currentStartTime) {
                        filterEndTimeSlots(currentStartTime);
                    }
                })
                .catch(error => {
                    console.error('Error fetching time slots:', error);
                    startTimeSlotSelect.innerHTML = '<option value="">Gagal memuat slot waktu</option>';
                    endTimeSlotSelect.innerHTML = '<option value="">Gagal memuat slot waktu</option>';
                });
        }

        function filterEndTimeSlots(selectedStartId) {
            Array.from(endTimeSlotSelect.options).forEach(option => {
                // Disable options that are before or equal to the selected start time
                if (option.value && parseInt(option.value) <= parseInt(selectedStartId)) {
                    option.disabled = true;
                    // If the current end time selection is now disabled, clear it
                    if (endTimeSlotSelect.value === option.value) {
                        endTimeSlotSelect.value = "";
                    }
                } else {
                    option.disabled = false;
                }
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
            filterEndTimeSlots(this.value);
        });
    });
</script>
@endpush