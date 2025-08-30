{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        {{-- (Bagian head tetap sama, tidak perlu diubah) --}}
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
         <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">

        <div class="flex h-screen bg-gray-200">
            <aside class="w-64 bg-gray-900 text-gray-200 flex flex-col">
           <!-- <div class="h-25 flex flex-col items-center justify-center bg-gray-900 m-5">
                <img src="{{ asset('klinik.jpg') }}"
                    alt="Klinik App Logo"
                    class="h-20 w-20 rounded-full object-cover  border-white mb-3">

            </div> -->
                <nav class="flex-1 px-4 py-4 space-y-2">
                    {{-- Link Dashboard --}}
                    <a href="{{ route('dashboard') }}" class="flex items-center  px-4 py-2.5 rounded-lg transition duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
                        {{-- Icon Dashboard (Heroicons) --}}
                        <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>

                    {{-- master --}}
                  <div x-data="{
                            open: {{ request()->routeIs('users.*') || request()->routeIs('patients.*') ||  request()->routeIs('doctors.*') || request()->routeIs('products.*') ? 'true' : 'false' }},
                            isActive: {{ request()->routeIs('users.*') || request()->routeIs('patients.*') || request()->routeIs('doctors.*') || request()->routeIs('products.*') ? 'true' : 'false' }}
                        }">

                        <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg transition duration-200"
                                :class="isActive ? 'bg-indigo-600 text-white' : 'hover:bg-gray-700 hover:text-white'">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                                </svg>
                                <span>Master Data</span>
                            </div>
                            <svg class="h-4 w-4 transform transition-transform duration-200" :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open" x-transition class="mt-2 pl-4 space-y-2">
                            <a href="{{ route('users.index') }}"
                            class="flex items-center w-full px-4 py-2 rounded-lg text-sm transition duration-200 {{ request()->routeIs('users.*') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
                            Manajemen User
                            </a>


                            <a href="{{ route('doctors.index') }}"
                            class="flex items-center w-full px-4 py-2 rounded-lg text-sm transition duration-200 {{ request()->routeIs('doctors.*') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
                            Manajemen Dokter
                            </a>

                            <a href="{{ route('products.index') }}"
                            class="flex items-center w-full px-4 py-2 rounded-lg text-sm transition duration-200 {{ request()->routeIs('products.*') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
                            Manajemen Produk
                            </a>
                            <a href="{{ route('patients.index') }}"
                            class="flex items-center w-full px-4 py-2 rounded-lg text-sm transition duration-200 {{ request()->routeIs('patients.*') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
                            Manajemen Pasien
                            </a>
                        </div>
                    </div>
                </nav>
            </aside>

            <div class="flex-1 flex flex-col overflow-hidden">
                <header class="bg-white shadow-md">
                    <div class="flex justify-end items-center h-16 px-6">
                        <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out">
                                <div class="flex-shrink-0">
                                    <svg class="h-10 w-10 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                                    </svg>
                                </div>

                                {{-- Nama + Role (tetap rata kiri) --}}
                                <div class="flex flex-col items-start ml-3">
                                    <div class="text-base font-semibold text-gray-800">
                                        {{ Auth::user()->name }}
                                    </div>
                                    <span class="text-xs text-gray-500">
                                        {{ Auth::user()->role }}
                                    </span>
                                </div>

                                {{-- Panah dropdown --}}
                                <div class="ml-3">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </header>
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200 p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
