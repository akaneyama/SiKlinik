<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="flex min-h-screen bg-gray-100">
            
            <div class="hidden lg:flex w-1/2 items-center justify-center bg-gradient-to-br from-indigo-600 to-blue-500 p-12 text-white">
                <div class="text-center">
                    <h1 class="text-4xl font-bold tracking-tight">Sistem Informasi Klinik</h1>
                    <p class="mt-4 text-lg opacity-80">Manajemen klinik terpadu untuk pelayanan yang lebih baik.</p>
                </div>
            </div>

            <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12">
                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
            </div>

        </div>
    </body>
</html>