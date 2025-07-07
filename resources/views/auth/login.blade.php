<?php
use App\Providers\RouteServiceProvider;
?>

<x-guest-layout>
    <div >
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-full h-full bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>
        </div>

        {{-- Floating Elements --}}
        <div class="absolute top-20 left-10 w-20 h-20 bg-gradient-to-r from-green-500 to-teal-500 rounded-full opacity-20 animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-16 h-16 bg-gradient-to-r from-emerald-600 to-lime-600 rounded-full opacity-20 animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-5 w-12 h-12 bg-gradient-to-r from-lime-500 to-green-600 rounded-full opacity-20 animate-pulse" style="animation-delay: 2s;"></div>

        <div class="flex flex-col items-center justify-center min-h-screen p-4 relative z-10">
            {{-- Logo Section --}}
            <div class="text-center mb-8 animate-fade-in">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-emerald-600 rounded-2xl blur opacity-75 group-hover:opacity-100 transition duration-300"></div>
                        <div class="relative bg-gradient-to-r from-black-600 to-black-600 p-6 rounded-2xl">
                            <x-application-logo class="w-48 h-auto fill-current text-white" />
                        </div>
                    </div>
                </a>
            </div>

            {{-- Status Message --}}
            <x-auth-session-status class="mb-6 text-green-400 max-w-md mx-auto text-center" :status="session('status')" />

            {{-- Login Form --}}
            <div>
                {{-- Glass Morphism Card --}}
                    {{-- Card Glow Effect --}}
                    
                    <form method="POST" action="{{ route('login') }}" class="space-y-6 relative">
                        @csrf

                        {{-- Email Field --}}
                        <div class="space-y-2">
                            <x-input-label for="email" :value="__('Email Address')" class="text-white font-semibold text-sm" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <x-text-input id="email" 
                                    class="block w-full pl-10 pr-4 py-3 bg-white/10 text-white border border-white/20 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/50 focus:bg-white/20 transition-all duration-300 placeholder-gray-300" 
                                    type="email" 
                                    name="email" 
                                    :value="old('email')" 
                                    required 
                                    autofocus 
                                    autocomplete="username"
                                    placeholder="Enter your email" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
                        </div>

                        {{-- Password Field --}}
                        <div class="space-y-2">
                            <x-input-label for="password" :value="__('Password')" class="text-white font-semibold text-sm" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <x-text-input id="password" 
                                    class="block w-full pl-10 pr-4 py-3 bg-white/10 text-white border border-white/20 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/50 focus:bg-white/20 transition-all duration-300 placeholder-gray-300" 
                                    type="password" 
                                    name="password" 
                                    required 
                                    autocomplete="current-password"
                                    placeholder="Enter your password" />
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
                        </div>

                        {{-- Remember Me & Forgot Password --}}
                        <div class="flex justify-between items-center">
                            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                                <input id="remember_me" 
                                    type="checkbox" 
                                    class="rounded-md bg-white/10 border-white/20 text-green-500 shadow-sm focus:ring-green-500 focus:ring-offset-0 focus:ring-2" 
                                    name="remember">
                                <span class="ml-2 text-sm text-gray-300 font-medium">Remember me</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-sm text-green-400 hover:text-green-300 font-medium transition-colors duration-200" 
                                    href="{{ route('password.request') }}">
                                    Forgot password?
                                </a>
                            @endif
                        </div>

                        {{-- Submit Button --}}
                        <div class="space-y-4">
                            <x-primary-button class="w-full py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-transparent">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                {{ __('Sign In') }}
                            </x-primary-button>
                        </div>

                        {{-- Divider --}}
                        <div class="relative flex items-center justify-center">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-white/20"></div>
                            </div>
                            <div class="relative bg-transparent px-4">
                                <span class="text-gray-400 text-sm">or</span>
                            </div>
                        </div>

                        {{-- Register Link --}}
                        @if (Route::has('register'))
                            <div class="text-center">
                                <p class="text-gray-300 text-sm">
                                    Don't have an account? 
                                    <a href="{{ route('register') }}" 
                                        class="text-green-400 hover:text-green-300 font-semibold transition-colors duration-200 hover:underline">
                                        Create Account
                                    </a>
                                </p>
                            </div>
                        @endif
                    </form>
                </div>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.6s ease-out;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(34, 197, 94, 0.5); /* green-500 opacity 0.5 */
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(34, 197, 94, 0.7); /* green-500 opacity 0.7 */
        }
    </style>
</x-guest-layout>