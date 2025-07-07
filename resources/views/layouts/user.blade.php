<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Booking Lapangan')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <nav class="bg-gradient-to-r from-blue-600 to-indigo-700 p-4 text-white shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('user.home') }}" class="text-2xl font-bold hover:text-blue-200">
                <i class="fas fa-futbol mr-2"></i>Booking Lapangan
            </a>
            <div>
                <ul class="flex space-x-6">
                    <li><a href="{{ route('user.home') }}" class="hover:text-blue-200">Beranda</a></li>
                    <li><a href="{{ route('user.bookings.history') }}" class="hover:text-blue-200">Riwayat Booking</a></li>
                    @guest
                        <li><a href="{{ route('login') }}" class="hover:text-blue-200">Login</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-blue-200">Register</a></li>
                    @else
                        <li class="relative group">
                            <a href="#" class="hover:text-blue-200 flex items-center">
                                {{ Auth::user()->name }} <i class="fas fa-chevron-down ml-2 text-xs"></i>
                            </a>
                            <ul class="absolute hidden group-hover:block bg-white text-gray-800 shadow-md rounded-md mt-2 w-48 py-2 z-50">
                                @if(Auth::user()->isAdmin())
                                    <li><a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-gray-100">Admin Dashboard</a></li>
                                @endif
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-8 p-4">
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
    </div>

    <footer class="bg-gray-800 text-white p-6 mt-12 text-center">
        <div class="container mx-auto">
            &copy; {{ date('Y') }} Booking Lapangan. All rights reserved.
        </div>
    </footer>

    @stack('scripts')
</body>
</html>