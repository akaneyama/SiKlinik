<x-app-layout>
    <div class="max-w-4xl mx-auto pb-12">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Pendaftaran Pasien Baru</h1>

        <form method="POST" action="{{ route('patients.store') }}">
            @csrf
            <div class="space-y-8" x-data="patientForm()">
                  {{-- ====================================================== --}}
                {{-- === BLOK UNTUK MENAMPILKAN RINGKASAN ERROR VALIDASI === --}}
                {{-- ====================================================== --}}
                @if ($errors->any())
                    <div class="p-4 mb-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="font-bold text-red-800">Terdapat Kesalahan Pengisian Form!</div>
                        <ul class="mt-2 list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                {{-- ====================================================== --}}

                {{-- Kartu Data Diri --}}
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="font-bold text-lg text-gray-800 border-b pb-2 mb-6">1. Data Diri Pasien</h3>
                    <div class="space-y-4">
                        <div>
                            <x-input-label for="nama_pasien" value="Nama Lengkap" />
                            <x-text-input id="nama_pasien" name="nama_pasien" type="text" class="mt-1 block w-full" :value="old('nama_pasien')" required />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="jenis_identitas" value="Jenis Identitas" />
                                <select id="jenis_identitas" name="jenis_identitas" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="KTP" @selected(old('jenis_identitas') == 'KTP')>KTP</option>
                                    <option value="SIM" @selected(old('jenis_identitas') == 'SIM')>SIM</option>
                                    <option value="Paspor" @selected(old('jenis_identitas') == 'Paspor')>Paspor</option>
                                    <option value="Lainnya" @selected(old('jenis_identitas') == 'Lainnya')>Lainnya</option>
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
                                    <option value="Laki-laki" @selected(old('jenis_kelamin') == 'Laki-laki')>Laki-laki</option>
                                    <option value="Perempuan" @selected(old('jenis_kelamin') == 'Perempuan')>Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="gol_darah" value="Golongan Darah" />
                                <select id="gol_darah" name="gol_darah" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">-- Pilih --</option>
                                    <option value="A" @selected(old('gol_darah') == 'A')>A</option>
                                    <option value="B" @selected(old('gol_darah') == 'B')>B</option>
                                    <option value="AB" @selected(old('gol_darah') == 'AB')>AB</option>
                                    <option value="O" @selected(old('gol_darah') == 'O')>O</option>
                                    <option value="Tidak Tahu" @selected(old('gol_darah') == 'Tidak Tahu')>Tidak Tahu</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="agama" value="Agama" />
                                <x-text-input id="agama" name="agama" type="text" class="mt-1 block w-full" :value="old('agama')" />
                            </div>
                            <div>
                                <x-input-label for="etnis" value="Etnis / Suku" />
                                <x-text-input id="etnis" name="etnis" type="text" class="mt-1 block w-full" :value="old('etnis')" />
                            </div>
                            <div>
                                <x-input-label for="kewarganegaraan" value="Kewarganegaraan" />
                                <x-text-input id="kewarganegaraan" name="kewarganegaraan" type="text" class="mt-1 block w-full" :value="old('kewarganegaraan')" />
                            </div>
                            <div>
                                <x-input-label for="tingkat_pendidikan" value="Pendidikan Terakhir" />
                                <x-text-input id="tingkat_pendidikan" name="tingkat_pendidikan" type="text" class="mt-1 block w-full" :value="old('tingkat_pendidikan')" />
                            </div>
                             <div class="md:col-span-2">
                                <x-input-label for="pekerjaan" value="Pekerjaan" />
                                <x-text-input id="pekerjaan" name="pekerjaan" type="text" class="mt-1 block w-full" :value="old('pekerjaan')" />
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
                             <div>
                                <x-input-label for="whatsapp" value="WhatsApp" />
                                <x-text-input id="whatsapp" name="whatsapp" type="text" class="mt-1 block w-full" :value="old('whatsapp')" />
                            </div>
                             <div>
                                <x-input-label for="telepon_domisili" value="Telepon Rumah" />
                                <x-text-input id="telepon_domisili" name="telepon_domisili" type="text" class="mt-1 block w-full" :value="old('telepon_domisili')" />
                            </div>
                        </div>
                         <div>
                            <x-input-label for="alamat_domisili" value="Alamat Domisili" />
                            <textarea id="alamat_domisili" name="alamat_domisili" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('alamat_domisili') }}</textarea>
                        </div>
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="desa_kelurahan" value="Desa / Kelurahan" />
                                <x-text-input id="desa_kelurahan" name="desa_kelurahan" type="text" class="mt-1 block w-full" :value="old('desa_kelurahan')" />
                            </div>
                            <div>
                                <x-input-label for="kecamatan" value="Kecamatan" />
                                <x-text-input id="kecamatan" name="kecamatan" type="text" class="mt-1 block w-full" :value="old('kecamatan')" />
                            </div>
                             <div>
                                <x-input-label for="kota" value="Kota / Kabupaten" />
                                <x-text-input id="kota" name="kota" type="text" class="mt-1 block w-full" :value="old('kota')" />
                            </div>
                            <div>
                                <x-input-label for="provinsi" value="Provinsi" />
                                <x-text-input id="provinsi" name="provinsi" type="text" class="mt-1 block w-full" :value="old('provinsi')" />
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="kode_pos" value="Kode Pos" />
                                <x-text-input id="kode_pos" name="kode_pos" type="text" class="mt-1 block w-full" :value="old('kode_pos')" />
                            </div>
                         </div>
                    </div>
                </div>

                {{-- Kartu Kontak Darurat --}}
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="font-bold text-lg text-gray-800 border-b pb-2 mb-6">3. Kontak Darurat</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="kerabat_pasien" value="Nama Kerabat" />
                            <x-text-input id="kerabat_pasien" name="kerabat_pasien" type="text" class="mt-1 block w-full" :value="old('kerabat_pasien')" />
                        </div>
                        <div>
                            <x-input-label for="hubungan_kerabat" value="Hubungan" />
                            <x-text-input id="hubungan_kerabat" name="hubungan_kerabat" type="text" class="mt-1 block w-full" :value="old('hubungan_kerabat')" />
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label for="no_telp_kerabat" value="No. Telepon Kerabat" />
                            <x-text-input id="no_telp_kerabat" name="no_telp_kerabat" type="text" class="mt-1 block w-full" :value="old('no_telp_kerabat')" />
                        </div>
                    </div>
                </div>

                {{-- Kartu Keanggotaan --}}
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="font-bold text-lg text-gray-800 border-b pb-2 mb-6">4. Keanggotaan (Opsional)</h3>
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
                    <h3 class="font-bold text-lg text-gray-800 border-b pb-2 mb-6">5. Asuransi</h3>
                    <div class="space-y-4">
                        <template x-for="(insurance, index) in insurances" :key="index">
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

                {{-- Kartu Informasi Lainnya --}}
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="font-bold text-lg text-gray-800 border-b pb-2 mb-6">6. Informasi Lainnya</h3>
                    <div class="space-y-4">
                        <div>
                            <x-input-label for="id_lama" value="No. Rekam Medis Lama (Jika Ada)" />
                            <x-text-input id="id_lama" name="id_lama" type="text" class="mt-1 block w-full" :value="old('id_lama')" />
                        </div>
                        <div>
                            <x-input-label for="perusahaan" value="Nama Perusahaan (Jika pasien tanggungan)" />
                            <x-text-input id="perusahaan" name="perusahaan" type="text" class="mt-1 block w-full" :value="old('perusahaan')" />
                        </div>
                        <div>
                            <x-input-label for="alamat_perusahaan" value="Alamat Perusahaan" />
                            <textarea id="alamat_perusahaan" name="alamat_perusahaan" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('alamat_perusahaan') }}</textarea>
                        </div>
                         <div>
                            <x-input-label for="telepon_perusahaan" value="Telepon Perusahaan" />
                            <x-text-input id="telepon_perusahaan" name="telepon_perusahaan" type="text" class="mt-1 block w-full" :value="old('telepon_perusahaan')" />
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-center justify-end">
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
                    this.insurances.push({
                        nama_asuransi: '',
                        no_polis: '',
                        nama_pemegang_polis: '',
                        jenis_asuransi: 'BPJS',
                        pivot: {
                            status_hubungan: 'Pemegang Polis',
                            nomor_kartu_pasien: ''
                        }
                    });
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