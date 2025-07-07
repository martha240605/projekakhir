<?php
use App\Providers\RouteServiceProvider; // Perlu jika ada RouteServiceProvider di file Anda, biasanya ada di template Breeze
?>

<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center p-4">
        <div class="text-center mb-8"> <a href="/" class="inline-block">
                <x-application-logo class="w-64 h-29 fill-current" /> 
            </a>
           
        </div>

        <x-auth-session-status class="mb-4 text-white max-w-md mx-auto" :status="session('status')" /> 

        <form method="POST" action="{{ route('login') }}" class="w-full max-w-md space-y-6">
            @csrf

            <div>
                <x-input-label for="email" :value="__('Email')" class="text-gray-300" />
                <x-text-input id="email" class="block mt-1 w-full bg-gray-800 text-white border-gray-700 focus:border-lime-500 focus:ring-lime-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" class="text-gray-300" />
                <x-text-input id="password" class="block mt-1 w-full bg-gray-800 text-white border-gray-700 focus:border-lime-500 focus:ring-lime-500" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-between items-center mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded bg-gray-800 border-gray-700 text-lime-500 shadow-sm focus:ring-lime-500 focus:ring-offset-black" name="remember">
                    <span class="ml-2 text-sm text-gray-300">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-300 hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-500 focus:ring-offset-black" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <div class="flex items-center justify-between mt-6">
                @if (Route::has('register'))
                    <a class="underline text-sm text-gray-300 hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-500 focus:ring-offset-black mr-4" href="{{ route('register') }}">
                        {{ __('Don\'t have an account? Register') }}
                    </a>
                @endif

                <x-primary-button class="ml-3 px-6 py-3 bg-lime-500 hover:bg-lime-600 active:bg-lime-700 focus:outline-none focus:ring-2 focus:ring-lime-500 focus:ring-offset-2 focus:ring-offset-black text-white font-bold rounded-lg">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>