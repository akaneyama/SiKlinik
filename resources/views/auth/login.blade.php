<x-guest-layout>
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full">
        
        <div class="flex flex-col items-center mb-6">
            <img src="{{ asset('klinik.jpg') }}"
                 alt="Klinik App Logo"
                 class="h-20 w-20 rounded-full object-cover border-4 border-white -mt-16 shadow-md">
            <h2 class="text-2xl font-bold text-gray-800 mt-4">Selamat Datang Kembali</h2>
            <p class="text-gray-500">Masuk untuk melanjutkan ke SIklinik</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password" value="Password" />
                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

           

            <div class="flex items-center justify-end mt-4">
                <!-- @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif -->

                <x-primary-button class="ms-3">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
             <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Daftar di sini
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>