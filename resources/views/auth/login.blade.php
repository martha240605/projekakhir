<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900"
         style="background-image: url('{{ asset('images/field_bg.jpg') }}'); background-size: cover; background-position: center;">
        <div class="w-full max-w-md p-8 space-y-8 bg-white dark:bg-gray-800 rounded-lg shadow-xl backdrop-blur-sm bg-opacity-90 dark:bg-opacity-90">
            <div class="flex flex-col items-center justify-center">
                <a href="/" class="mb-4">
                    <x-application-logo class="w-20 h-20 fill-current text-green-600 dark:text-green-400" />
                </a>
                <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white">
                    Welcome to Field Booking!
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
                    Sign in to your account
                </p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex justify-between items-center mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('register'))
                        <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 mr-4" href="{{ route('register') }}">
                            {{ __('Don\'t have an account? Register') }}
                        </a>
                    @endif

                    <x-primary-button class="ml-3 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>