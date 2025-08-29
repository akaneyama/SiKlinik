{{-- resources/views/users/edit.blade.php --}}
<x-app-layout>
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit User: {{ $user->name }}</h1>

        <div class="bg-white p-8 rounded-lg shadow-lg">
            <form method="POST" action="{{ route('users.update', $user->id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="name" :value="__('Nama Lengkap')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Alamat Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="role" :value="__('Role')" />
                    <select name="role" id="role" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                          <option value="pegawai" {{ old('role' , $user->role) == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                        <option value="dokter" {{ old('role', $user->role) == 'dokter' ? 'selected' : '' }}>Dokter</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="apoteker" {{ old('role', $user->role) == 'apoteker' ? 'selected' : '' }}>Apoteker</option>
                        <option value="administrasi" {{ old('role', $user->role) == 'administrasi' ? 'selected' : '' }}>Administrasi</option>
                    </select>
                     <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>

                <div class="border-t border-gray-200 pt-6">
                    <p class="text-sm text-gray-600 mb-4">Ubah Password (Opsional)</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="password" :value="__('Password Baru')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end pt-4 border-t border-gray-200">
                    <a href="{{ route('users.index') }}" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900 mr-4">
                        Batal
                    </a>
                    <x-primary-button>
                        Update User
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
