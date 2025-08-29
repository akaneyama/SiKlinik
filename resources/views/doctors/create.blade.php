<x-app-layout>
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Data Dokter</h1>

        <div class="bg-white p-8 rounded-lg shadow-lg" x-data="doctorForm()">
            <form method="POST" action="{{ route('doctors.store') }}">
                @csrf

                {{-- Bagian data dokter (tidak ada perubahan) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="id_user" value="Pilih Akun User (Dokter)" />
                        <select name="id_user" id="id_user" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <option value="">-- Pilih Akun --</option>
                            @foreach ($users as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('id_user')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="nama_dokter" value="Nama Lengkap Dokter (dengan gelar)" />
                        <x-text-input id="nama_dokter" class="block mt-1 w-full" type="text" name="nama_dokter" :value="old('nama_dokter')" required />
                        <x-input-error :messages="$errors->get('nama_dokter')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="no_str" value="Nomor STR" />
                        <x-text-input id="no_str" class="block mt-1 w-full" type="text" name="no_str" :value="old('no_str')" required />
                        <x-input-error :messages="$errors->get('no_str')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="spesialisasi" value="Spesialisasi" />
                        <x-text-input id="spesialisasi" class="block mt-1 w-full" type="text" name="spesialisasi" :value="old('spesialisasi')" required />
                        <x-input-error :messages="$errors->get('spesialisasi')" class="mt-2" />
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Jadwal Praktek</h3>

                    <template x-for="(schedule, index) in schedules" :key="index">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center mb-4">
                            <div>
                                <x-input-label value="Hari" />
                                <select x-bind:name="getName(index, 'hari')" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" x-model="schedule.hari">
                                    {{-- PERUBAHAN DI SINI --}}
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                    <option value="Sabtu">Sabtu</option>
                                    <option value="Minggu">Minggu</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label value="Jam Mulai" />
                                <x-text-input type="time" x-bind:name="getName(index, 'jam_mulai')" class="mt-1 block w-full" x-model="schedule.jam_mulai" />
                                {{-- PERUBAHAN DI SINI --}}
                            </div>
                            <div>
                                <x-input-label value="Jam Selesai" />
                                <x-text-input type="time" x-bind:name="getName(index, 'jam_selesai')" class="mt-1 block w-full" x-model="schedule.jam_selesai" />
                                {{-- PERUBAHAN DI SINI --}}
                            </div>
                            <div class="pt-6">
                                <button type="button" @click="removeSchedule(index)" class="px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">&times; Hapus</button>
                            </div>
                        </div>
                    </template>

                    <button type="button" @click="addSchedule()" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">+ Tambah Jadwal</button>
                </div>

                <div class="flex items-center justify-end pt-6 mt-6 border-t">
                    <a href="{{ route('doctors.index') }}" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                    <x-primary-button>Simpan Data Dokter</x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function doctorForm() {
            return {
                schedules: [{ hari: 'Senin', jam_mulai: '', jam_selesai: '' }],

                // --- FUNGSI BARU UNTUK MEMBUAT NAMA INPUT ---
                getName(index, field) {
                    return `jadwal[${index}][${field}]`;
                },
                // ---------------------------------------------

                addSchedule() {
                    this.schedules.push({ hari: 'Senin', jam_mulai: '', jam_selesai: '' });
                },
                removeSchedule(index) {
                    if (this.schedules.length > 1) {
                        this.schedules.splice(index, 1);
                    }
                }
            }
        }
    </script>
</x-app-layout>
