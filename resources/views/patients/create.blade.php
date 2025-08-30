<x-app-layout>
    <div class="max-w-4xl mx-auto pb-12">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Pendaftaran Pasien Baru</h1>

        <form method="POST" action="{{ route('patients.store') }}">
            @csrf
            {{-- Tata letak utama diubah menjadi 1 kolom dengan space-y-8 --}}
            <div class="space-y-8" x-data="patientForm()">

                {{-- Kartu Data Diri --}}
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="font-bold text-lg text-gray-800 border-b pb-2 mb-6">1. Data Diri Pasien</h3>
                    <div class="space-y-4">
                        <div>
                            <x-input-label for="nama_pasien" value="Nama Lengkap" />
                            <x-text-input id="nama_pasien" name="nama_pasien" type="text" class="mt-1 block w-full" :value="old('nama_pasien')" required />
                        </div>
                        {{-- Struktur grid di 'Data Diri' diperbaiki agar lebih rapi --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="jenis_identitas" value="Jenis Identitas" />
                                <select id="jenis_identitas" name="jenis_identitas" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="KTP">KTP</option>
                                    <option value="SIM">SIM</option>
                                    <option value="Paspor">Paspor</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="no_identitas" value="Nomor Identitas" />
                                <x-text-input id="no_identitas" name="no_identitas" type="text" class="mt-1 block w-full" :value="old('no_identitas')" />
                            </div>
                            <div>
                                <x-input-label for="tempat_lahir" value="Tempat Lahir" />
                                <x-text-input id="tempat_lahir" name="tempat_lahir" type="text" class="mt-1 block w-full" :value="old('tempat_lahir')" />
                            </div>
                            <div>
                                <x-input-label for="tanggal_lahir" value="Tanggal Lahir" />
                                <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date" class="mt-1 block w-full" :value="old('tanggal_lahir')" />
                            </div>
                            <div>
                                <x-input-label for="jenis_kelamin" value="Jenis Kelamin" />
                                <select id="jenis_kelamin" name="jenis_kelamin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="gol_darah" value="Golongan Darah" />
                                <select id="gol_darah" name="gol_darah" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">-- Pilih --</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                    <option value="Tidak Tahu">Tidak Tahu</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kartu Kontak & Alamat --}}
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="font-bold text-lg text-gray-800 border-b pb-2 mb-6">2. Kontak & Alamat</h3>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="email" value="Email" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" />
                            </div>
                            <div>
                                <x-input-label for="nomor_telp" value="Nomor Telepon" />
                                <x-text-input id="nomor_telp" name="nomor_telp" type="text" class="mt-1 block w-full" :value="old('nomor_telp')" />
                            </div>
                        </div>
                         <div>
                            <x-input-label for="alamat_domisili" value="Alamat Domisili" />
                            <textarea id="alamat_domisili" name="alamat_domisili" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('alamat_domisili') }}</textarea>
                        </div>
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="provinsi" value="Provinsi" />
                                <x-text-input id="provinsi" name="provinsi" type="text" class="mt-1 block w-full" :value="old('provinsi')" />
                            </div>
                            <div>
                                <x-input-label for="kota" value="Kota / Kabupaten" />
                                <x-text-input id="kota" name="kota" type="text" class="mt-1 block w-full" :value="old('kota')" />
                            </div>
                            <div>
                                <x-input-label for="kecamatan" value="Kecamatan" />
                                <x-text-input id="kecamatan" name="kecamatan" type="text" class="mt-1 block w-full" :value="old('kecamatan')" />
                            </div>
                            <div>
                                <x-input-label for="desa_kelurahan" value="Desa / Kelurahan" />
                                <x-text-input id="desa_kelurahan" name="desa_kelurahan" type="text" class="mt-1 block w-full" :value="old('desa_kelurahan')" />
                            </div>
                         </div>
                    </div>
                </div>

                {{-- Kartu Keanggotaan --}}
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="font-bold text-lg text-gray-800 border-b pb-2 mb-6">3. Keanggotaan (Opsional)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                       <div>
                          <x-input-label for="jenis_keanggotaan" value="Jenis Keanggotaan" />
                          <x-text-input id="jenis_keanggotaan" name="jenis_keanggotaan" type="text" class="mt-1 block w-full" :value="old('jenis_keanggotaan')" placeholder="Warga Muhammadiyah, Prolanis, dll."/>
                       </div>
                       <div>
                          <x-input-label for="keanggotaan_kadaluarsa" value="Tanggal Kadaluarsa" />
                          <x-text-input id="keanggotaan_kadaluarsa" name="keanggotaan_kadaluarsa" type="date" class="mt-1 block w-full" :value="old('keanggotaan_kadaluarsa')" />
                       </div>
                    </div>
                </div>

                {{-- Kartu Asuransi --}}
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="font-bold text-lg text-gray-800 border-b pb-2 mb-6">4. Asuransi</h3>
                    <div class="space-y-4">
                        <template x-for="(insurance, index) in insurances" :key="index">
                            {{-- Ditambahkan 'relative' agar posisi tombol 'X' pas --}}
                            <div class="p-4 border rounded-lg relative space-y-4 bg-gray-50">
                                <button type="button" @click="removeInsurance(index)" class="absolute top-3 right-3 h-7 w-7 flex items-center justify-center bg-red-200 text-red-700 rounded-full hover:bg-red-300 transition-colors">&times;</button>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="md:col-span-2">
                                        <x-input-label ::for="'nama_asuransi_' + index" value="Nama Asuransi"/>
                                        <x-text-input ::id="'nama_asuransi_' + index" x-bind:name="getName(index, 'nama_asuransi')" type="text" class="mt-1 block w-full"/>
                                    </div>
                                    <div class="md:col-span-2">
                                        <x-input-label ::for="'no_polis_' + index" value="No. Polis"/>
                                        <x-text-input ::id="'no_polis_' + index" x-bind:name="getName(index, 'no_polis')" type="text" class="mt-1 block w-full"/>
                                    </div>
                                    <div class="md:col-span-2">
                                        <x-input-label ::for="'nama_pemegang_polis_' + index" value="Nama Pemegang Polis"/>
                                        <x-text-input ::id="'nama_pemegang_polis_' + index" x-bind:name="getName(index, 'nama_pemegang_polis')" type="text" class="mt-1 block w-full"/>
                                    </div>
                                    <div>
                                        <x-input-label ::for="'jenis_asuransi_' + index" value="Jenis"/>
                                        <select ::id="'jenis_asuransi_' + index" x-bind:name="getName(index, 'jenis_asuransi')" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                            <option value="BPJS">BPJS</option>
                                            <option value="Non-BPJS">Non-BPJS</option>
                                        </select>
                                    </div>
                                    <div>
                                        <x-input-label ::for="'status_hubungan_' + index" value="Hubungan"/>
                                        <select ::id="'status_hubungan_' + index" x-bind:name="getName(index, 'status_hubungan')" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                            <option value="Pemegang Polis">Pemegang Polis</option>
                                            <option value="Suami/Istri">Suami/Istri</option>
                                            <option value="Anak">Anak</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                     <div class="md:col-span-2">
                                        <x-input-label ::for="'nomor_kartu_pasien_' + index" value="No. Kartu Pasien (jika beda)"/>
                                        <x-text-input ::id="'nomor_kartu_pasien_' + index" x-bind:name="getName(index, 'nomor_kartu_pasien')" type="text" class="mt-1 block w-full"/>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <button type="button" @click="addInsurance()" class="w-full mt-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">+ Tambah Asuransi</button>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-center justify-end mt-6">
                    <a href="{{ route('patients.index') }}" class="text-gray-600 mr-4">Batal</a>
                    <x-primary-button>
                        Simpan Pasien
                    </x-primary-button>
                </div>
            </div>
        </form>
    </div>
    <script>
        function patientForm() {
            return {
                insurances: [],
                addInsurance() {
                    this.insurances.push({});
                },
                removeInsurance(index) {
                    this.insurances.splice(index, 1);
                },
                getName(index, field) {
                    return `insurances[${index}][${field}]`;
                }
            }
        }
    </script>
</x-app-layout>

