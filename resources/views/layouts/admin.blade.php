<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    @stack('styles')
    <style>
        /* Custom scrollbar for sidebar (optional) */
        .sidebar-scroll {
            -ms-overflow-style: none; /* IE and Edge */
            scrollbar-width: none; /* Firefox */
        }
        .sidebar-scroll::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }
    </style>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal flex">

    <aside class="w-64 bg-gray-800 text-white min-h-screen p-4 flex flex-col sidebar-scroll">
        <div class="text-2xl font-bold text-center mb-10 mt-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-300">Admin Panel</a>
        </div>
        <nav class="flex-grow">
            <ul>
                <li class="mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-200
                        {{ Request::routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                        <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('admin.fields.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-200
                        {{ Request::routeIs('admin.fields.*') ? 'bg-gray-700' : '' }}">
                        <i class="fas fa-futbol mr-3"></i> Lapangan
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('admin.bookings.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-200
                        {{ Request::routeIs('admin.bookings.*') ? 'bg-gray-700' : '' }}">
                        <i class="fas fa-calendar-alt mr-3"></i> Booking
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('admin.time-slots.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-200
                        {{ Request::routeIs('admin.time-slots.*') ? 'bg-gray-700' : '' }}">
                        <i class="fas fa-clock mr-3"></i> Slot Waktu
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('admin.users.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-200
                        {{ Request::routeIs('admin.users.*') ? 'bg-gray-700' : '' }}">
                        <i class="fas fa-users mr-3"></i> Pengguna
                    </a>
                </li>
            </ul>
        </nav>
        <div class="mt-auto">
            <hr class="border-gray-700 my-4">
            <ul>
                <li class="mb-2">
                    <a href="{{ route('user.home') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-200">
                        <i class="fas fa-home mr-3"></i> Ke Halaman User
                    </a>
                </li>
                <li class="mb-2">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-200 w-full text-left">
                            <i class="fas fa-sign-out-alt mr-3"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="flex justify-between items-center bg-white p-4 shadow-md z-10">
            <div class="text-xl font-semibold text-gray-800">
                @yield('header_title', 'Dashboard')
            </div>
            <div class="flex items-center">
                <span class="text-gray-700 mr-4">{{ Auth::user()->name }} (Admin)</span>
                <img class="h-10 w-10 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF" alt="Admin Avatar">
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p><strong>Oops! Ada beberapa masalah:</strong></p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="bg-white p-4 shadow-inner text-center text-gray-600 border-t">
            &copy; {{ date('Y') }} Admin Panel. All rights reserved.
        </footer>
    </div>

    @stack('scripts')
</body>
</html>