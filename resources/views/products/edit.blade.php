<x-app-layout>
    <div class="max-w-4xl mx-auto pb-12">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Produk: {{ $product->nama_produk }}</h1>

        <form method="POST" action="{{ route('products.update', $product->id_produk) }}" enctype="multipart/form-data"> {{-- TAMBAHKAN INI --}}
            @csrf
            @method('PUT')
            <div class="bg-white p-8 rounded-lg shadow-lg" x-data="{ productType: '{{ old('jenis_produk', $product->jenis_produk) }}' }">

                {{-- === BAGIAN JENIS PRODUK (Pemicu Dinamis) === --}}
                <div class="mb-6">
                    <x-input-label for="jenis_produk" value="Jenis Produk" />
                    <select name="jenis_produk" id="jenis_produk" x-model="productType" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        <option value="OBAT" {{ old('jenis_produk', $product->jenis_produk) == 'OBAT' ? 'selected' : '' }}>OBAT</option>
                        <option value="SUPLAI" {{ old('jenis_produk', $product->jenis_produk) == 'SUPLAI' ? 'selected' : '' }}>SUPLAI</option>
                    </select>
                    <x-input-error :messages="$errors->get('jenis_produk')" class="mt-2" />
                </div>

                {{-- === BAGIAN KHUSUS OBAT === --}}
                <div x-show="productType === 'OBAT'" x-transition class="p-4 mb-6 bg-green-50 border border-green-200 rounded-lg space-y-4">
                    <h3 class="font-bold text-green-800">Detail Khusus Obat</h3>
                    <div>
                        <x-input-label for="nama_generik" value="Nama Generik" />
                        <x-text-input id="nama_generik" name="nama_generik" type="text" class="mt-1 block w-full" :value="old('nama_generik', $product->nama_generik)" />
                        <x-input-error :messages="$errors->get('nama_generik')" class="mt-2" />
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="dosis" value="Dosis (cth: 500 mg)" />
                            <x-text-input id="dosis" name="dosis" type="text" class="mt-1 block w-full" :value="old('dosis', $product->dosis)" />
                            <x-input-error :messages="$errors->get('dosis')" class="mt-2" />
                        </div>
                        <div x-data="dropdownSearch()" class="relative w-full">
                            <x-input-label for="bentuk_sediaan" value="Bentuk Sediaan" />

                            <input
                                type="text"
                                x-model="search"
                                @focus="open = true"
                                @click.away="open = false"
                                placeholder="Cari bentuk sediaan..."
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                                    focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            >

                            <input type="hidden" name="bentuk_sediaan" :value="selected">

                            <div x-show="open"
                                class="absolute z-10 mt-1 w-full bg-white border
                                        border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto">

                                <template x-for="item in filtered" :key="item">
                                    <div @click="choose(item)"
                                        class="cursor-pointer px-3 py-2 hover:bg-indigo-500 hover:text-white"
                                        x-text="item"></div>
                                </template>
                            </div>

                            <x-input-error :messages="$errors->get('bentuk_sediaan')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="batch" value="No. Batch" />
                            <x-text-input id="batch" name="batch" type="text" class="mt-1 block w-full" :value="old('batch', $product->batch)" />
                            <x-input-error :messages="$errors->get('batch')" class="mt-2" />
                        </div>
                    </div>
                    <div>
                        <x-input-label for="tgl_kadaluarsa" value="Tanggal Kadaluarsa" />
                        <x-text-input id="tgl_kadaluarsa" name="tgl_kadaluarsa" type="date" class="mt-1 block w-full" :value="old('tgl_kadaluarsa', $product->tgl_kadaluarsa ? $product->tgl_kadaluarsa->format('Y-m-d') : '')" />
                        <x-input-error :messages="$errors->get('tgl_kadaluarsa')" class="mt-2" />
                    </div>
                </div>

                {{-- === BAGIAN KHUSUS SUPLAI === --}}
                <div x-show="productType === 'SUPLAI'" x-transition class="p-4 mb-6 bg-purple-50 border border-purple-200 rounded-lg space-y-4">
                    <h3 class="font-bold text-purple-800">Detail Khusus Suplai</h3>
                    <div>
                        <x-input-label for="no_seri" value="Nomor Seri" />
                        <x-text-input id="no_seri" name="no_seri" type="text" class="mt-1 block w-full" :value="old('no_seri', $product->no_seri)" />
                        <x-input-error :messages="$errors->get('no_seri')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="tgl_akhir_garansi" value="Tanggal Akhir Garansi" />
                        <x-text-input id="tgl_akhir_garansi" name="tgl_akhir_garansi" type="date" class="mt-1 block w-full" :value="old('tgl_akhir_garansi', $product->tgl_akhir_garansi ? $product->tgl_akhir_garansi->format('Y-m-d') : '')" />
                        <x-input-error :messages="$errors->get('tgl_akhir_garansi')" class="mt-2" />
                    </div>
                </div>

                {{-- === BAGIAN DATA UMUM === --}}
                <div class="space-y-4">
                    <h3 class="font-bold text-gray-800 border-b pb-2">Data Umum</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="nama_produk" value="Nama Produk/Merek" />
                            <x-text-input id="nama_produk" name="nama_produk" type="text" class="mt-1 block w-full" :value="old('nama_produk', $product->nama_produk)" required />
                            <x-input-error :messages="$errors->get('nama_produk')" class="mt-2" />
                        </div>
                         <div>
                            <x-input-label for="sku_barcode" value="SKU / Barcode" />
                            <x-text-input id="sku_barcode" name="sku_barcode" type="text" class="mt-1 block w-full" :value="old('sku_barcode', $product->sku_barcode)" required />
                            <x-input-error :messages="$errors->get('sku_barcode')" class="mt-2" />
                        </div>
                    </div>
                    {{-- Input Gambar & Preview --}}
                    <div class="mt-4">
                        <x-input-label for="gambar_produk" value="Gambar Produk (Opsional)" />
                        @if ($product->gambar_produk)
                            <div class="mt-2 flex items-center space-x-4">
                                <img src="{{ asset('storage/' . $product->gambar_produk) }}" alt="Gambar Produk" class="h-24 w-24 object-cover rounded-md border">
                                <label for="delete_gambar" class="flex items-center">
                                    <input type="checkbox" name="delete_gambar" id="delete_gambar" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-red-600">Hapus gambar ini</span>
                                </label>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">Upload gambar baru untuk mengganti gambar yang ada.</p>
                        @endif
                        <input id="gambar_produk" name="gambar_produk" type="file" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" accept="image/*" />
                        <x-input-error :messages="$errors->get('gambar_produk')" class="mt-2" />
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                         <div>
                            <x-input-label for="pabrikan" value="Pabrikan" />
                            <x-text-input id="pabrikan" name="pabrikan" type="text" class="mt-1 block w-full" :value="old('pabrikan', $product->pabrikan)" />
                            <x-input-error :messages="$errors->get('pabrikan')" class="mt-2" />
                        </div>
                         {{-- <div>
                            <x-input-label for="kategori" value="Kategori" />
                            <x-text-input id="kategori" name="kategori" type="text" class="mt-1 block w-full" :value="old('kategori', $product->kategori)" />
                            <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                        </div> --}}
                        <div x-data="multiselect()">
                        <x-input-label for="kategori" value="Kategori (Bisa pilih lebih dari satu)" />

                        {{-- Hidden inputs untuk mengirim data array ke backend --}}
                        <template x-for="cat in selected" :key="cat">
                            <input type="hidden" name="kategori[]" :value="cat">
                        </template>

                        <div class="relative mt-1">
                            <div @click.away="open = false" class="w-full flex flex-wrap gap-2 p-2 border border-gray-300 rounded-md shadow-sm bg-white">

                                <template x-for="cat in selected" :key="cat">
                                    <span class="inline-flex items-center px-2 py-1 bg-indigo-500 text-white text-sm font-medium rounded-full">
                                        <span x-text="cat"></span>
                                        <button @click.prevent="remove(cat)" type="button" class="ml-1.5 flex-shrink-0 text-indigo-200 hover:text-white focus:outline-none">
                                            &times;
                                        </button>
                                    </span>
                                </template>


                                <div class="flex-grow">
                                    <input
                                        type="text"
                                        x-model="search"
                                        @focus="open = true"
                                        placeholder="Cari atau tambah kategori..."
                                        class="w-full border-none p-0 focus:ring-0 sm:text-sm"
                                    >
                                </div>
                            </div>


                            <div x-show="open" x-transition class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto">
                                <template x-for="item in filtered" :key="item">
                                    <div @click="choose(item)"
                                        class="cursor-pointer px-3 py-2 hover:bg-indigo-500 hover:text-white"
                                        x-text="item">
                                    </div>
                                </template>
                                <div x-show="filtered.length === 0 && search.length > 0" class="px-3 py-2 text-gray-500">
                                    Tidak ada hasil.
                                </div>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                    </div>

                    </div>
                    <div>
                        <x-input-label for="digunakan_untuk" value="Digunakan Untuk" />
                        <x-text-input id="digunakan_untuk" name="digunakan_untuk" type="text" class="mt-1 block w-full" :value="old('digunakan_untuk', $product->digunakan_untuk)" />
                        <x-input-error :messages="$errors->get('digunakan_untuk')" class="mt-2" />
                    </div>
                </div>

                {{-- === BAGIAN STOK === --}}
                <div class="space-y-4 mt-6">
                    <h3 class="font-bold text-gray-800 border-b pb-2">Stok</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="kontrol_stok" value="Kontrol Stok" />
                            <select name="kontrol_stok" id="kontrol_stok" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="1" {{ old('kontrol_stok', $product->kontrol_stok) == 1 ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('kontrol_stok', $product->kontrol_stok) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            <x-input-error :messages="$errors->get('kontrol_stok')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="stok_awal" value="Stok Awal" />
                            <x-text-input id="stok_awal" name="stok_awal" type="number" step="any" class="mt-1 block w-full" :value="old('stok_awal', $product->stok_awal)" required />
                            <x-input-error :messages="$errors->get('stok_awal')" class="mt-2" />
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <x-input-label for="min_stok" value="Min. Stok" />
                                <x-text-input id="min_stok" name="min_stok" type="number" step="any" class="mt-1 block w-full" :value="old('min_stok', $product->min_stok)" required />
                                <x-input-error :messages="$errors->get('min_stok')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="max_stok" value="Max. Stok" />
                                <x-text-input id="max_stok" name="max_stok" type="number" step="any" class="mt-1 block w-full" :value="old('max_stok', $product->max_stok)" required />
                                <x-input-error :messages="$errors->get('max_stok')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                {{-- === BAGIAN HARGA === --}}
                <div class="space-y-4 mt-6">
                    <h3 class="font-bold text-gray-800 border-b pb-2">Harga</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="harga_modal" value="Harga Modal" />
                            <x-text-input id="harga_modal" name="harga_modal" type="number" step="any" class="mt-1 block w-full" :value="old('harga_modal', $product->harga_modal)" required />
                            <x-input-error :messages="$errors->get('harga_modal')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="harga_modal_diskon" value="Harga Modal (Setelah Diskon)" />
                            <x-text-input id="harga_modal_diskon" name="harga_modal_diskon" type="number" step="any" class="mt-1 block w-full" :value="old('harga_modal_diskon', $product->harga_modal_diskon)" />
                            <x-input-error :messages="$errors->get('harga_modal_diskon')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="markup" value="Markup (%)" />
                            <x-text-input id="markup" name="markup" type="number" step="any" class="mt-1 block w-full" :value="old('markup', $product->markup)" />
                            <x-input-error :messages="$errors->get('markup')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="harga_jual" value="Harga Jual" />
                            <x-text-input id="harga_jual" name="harga_jual" type="number" step="any" class="mt-1 block w-full" :value="old('harga_jual', $product->harga_jual)" required />
                            <x-input-error :messages="$errors->get('harga_jual')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="harga_spesial" value="Harga Spesial (Opsional)" />
                            <x-text-input id="harga_spesial" name="harga_spesial" type="number" step="any" class="mt-1 block w-full" :value="old('harga_spesial', $product->harga_spesial)" />
                            <x-input-error :messages="$errors->get('harga_spesial')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="cakupan_harga" value="Cakupan Harga" />
                            <select name="cakupan_harga" id="cakupan_harga" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="Lokal" {{ old('cakupan_harga', $product->cakupan_harga) == 'Lokal' ? 'selected' : '' }}>Lokal</option>
                                <option value="Global" {{ old('cakupan_harga', $product->cakupan_harga) == 'Global' ? 'selected' : '' }}>Global</option>
                            </select>
                            <x-input-error :messages="$errors->get('cakupan_harga')" class="mt-2" />
                        </div>
                    </div>
                </div>

                {{-- === BAGIAN KEMASAN & KONVERSI === --}}
                <div class="space-y-4 mt-6">
                    <h3 class="font-bold text-gray-800 border-b pb-2">Kemasan & Konversi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        {{-- <div>
                            <x-input-label for="kemasan_besar" value="Kemasan Besar (cth: Dus)" />
                            <x-text-input id="kemasan_besar" name="kemasan_besar" type="text" class="mt-1 block w-full" :value="old('kemasan_besar', $product->kemasan_besar)" />
                            <x-input-error :messages="$errors->get('kemasan_besar')" class="mt-2" />
                        </div> --}}
                        <div x-data="dropdownSearchkemasanbesar()" class="relative w-full">
                            <x-input-label for="kemasan_besar" value="kemasan_besar" />

                            <input
                                type="text"
                                x-model="search"
                                @focus="open = true"
                                @click.away="open = false"
                                placeholder="Cari Kemasan Besar...."
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                                    focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            >

                            <input type="hidden" name="kemasan_besar" :value="selected">

                            <div x-show="open"
                                class="absolute z-10 mt-1 w-full bg-white border
                                        border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto">

                                <template x-for="item in filtered" :key="item">
                                    <div @click="choose(item)"
                                        class="cursor-pointer px-3 py-2 hover:bg-indigo-500 hover:text-white"
                                        x-text="item"></div>
                                </template>
                            </div>

                            <x-input-error :messages="$errors->get('kemasan_besar')" class="mt-2" />
                        </div>
                        {{-- <div>
                            <x-input-label for="kemasan_kecil" value="Kemasan Kecil (cth: Blister)" />
                            <x-text-input id="kemasan_kecil" name="kemasan_kecil" type="text" class="mt-1 block w-full" :value="old('kemasan_kecil', $product->kemasan_kecil)" />
                            <x-input-error :messages="$errors->get('kemasan_kecil')" class="mt-2" />
                        </div> --}}
                        <div x-data="dropdownSearchkemasankecil()" class="relative w-full">
                            <x-input-label for="kemasan_kecil" value="kemasan_kecil" />

                            <input
                                type="text"
                                x-model="search"
                                @focus="open = true"
                                @click.away="open = false"
                                placeholder="Cari Kemasan Kecil...."
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                                    focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            >

                            <input type="hidden" name="kemasan_kecil" :value="selected">

                            <div x-show="open"
                                class="absolute z-10 mt-1 w-full bg-white border
                                        border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto">

                                <template x-for="item in filtered" :key="item">
                                    <div @click="choose(item)"
                                        class="cursor-pointer px-3 py-2 hover:bg-indigo-500 hover:text-white"
                                        x-text="item"></div>
                                </template>
                            </div>

                            <x-input-error :messages="$errors->get('kemasan_kecil')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="pembagi_konversi" value="Konversi (1 Bsr = ... Kcl)" />
                            <x-text-input id="pembagi_konversi" name="pembagi_konversi" type="number" step="any" class="mt-1 block w-full" :value="old('pembagi_konversi', $product->pembagi_konversi)" />
                            <x-input-error :messages="$errors->get('pembagi_konversi')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-8 pt-6 border-t">
                    <a href="{{ route('products.index') }}" class="text-gray-600 mr-4">Batal</a>
                    <x-primary-button>
                        Update Produk
                    </x-primary-button>
                </div>

            </div>
        </form>
    </div>
    <script>
    function dropdownSearch() {
        return {
            open: false,
            search: '{{ old('bentuk_sediaan', $product->bentuk_sediaan) }}', // isi field
            selected: '{{ old('bentuk_sediaan', $product->bentuk_sediaan) }}', // nilai yang dipilih
            items: [
                'Aerosol','Bedak padat','Bubuk','Cairan','Cairan inhalasi','Cairan oral','Custom','Form','Granula','Habis pakai','Infus',
                'Inhaler','Injeksi','Jel','Kaplet','Kapsul','Krim','Lotion','Nebulizer','Obat kumur','Odol','Oil','Patch','Pessari','Racikan',
                'Sabun','Salep','Salep mata','Semprot','Semprot hidung','Shampoo','Sirup','Sirup kering','Supositoria','Suspensi','Tablet',
                'Tablet hisap','Tablet kunyah','Tetes','Tetes hidung','Tetes mata','Tetes telinga','Tube anus'
            ],
            get filtered() {
                return this.items.filter(i =>
                    i.toLowerCase().includes(this.search.toLowerCase())
                );
            },
            choose(item) {
                this.selected = item;
                this.search = item;
                this.open = false;
            }
        }
    }
    function dropdownSearchkemasanbesar() {
        return {
        open: false,
        search: '{{ old('kemasan_besar',$product->kemasan_besar) }}',
        selected: '{{ old('kemasan_besar',$product->kemasan_besar) }}',
        items: [
            'Ampul', 'Botol', 'Botol kaca', 'Buah', 'Bungkus', 'Cc', 'Cm', 'Dus', 'Gram',
            'Inch', 'Kaleng', 'Kantong', 'Kaplet', 'Kapsul', 'Kg', 'Kolf', 'Kotak',
            'Lembar', 'Liter', 'Lusin', 'Meter', 'Mg', 'Ml', 'Pak', 'Pasang', 'Pot',
            'Rim', 'Rol', 'Sachet', 'Set', 'Shot', 'Strip', 'Supp', 'Syringe',
            'Tablet', 'Tas', 'Tes', 'Tube', 'Unit', 'Vial', 'Zak'
        ],
        get filtered() {
            return this.items.filter(i =>
            i.toLowerCase().includes(this.search.toLowerCase())
            );
        },
        choose(item) {
            this.selected = item;
            this.search = item;
            this.open = false;
        }
        }
        }
        function dropdownSearchkemasankecil() {
        return {
        open: false,
        search: '{{ old('kemasan_kecil',$product->kemasan_kecil) }}',
        selected: '{{ old('kemasan_kecil',$product->kemasan_kecil) }}',
        items: [
            'Ampul', 'Botol', 'Botol kaca', 'Buah', 'Bungkus', 'Cc', 'Cm', 'Dus', 'Gram',
            'Inch', 'Kaleng', 'Kantong', 'Kaplet', 'Kapsul', 'Kg', 'Kolf', 'Kotak',
            'Lembar', 'Liter', 'Lusin', 'Meter', 'Mg', 'Ml', 'Pak', 'Pasang', 'Pot',
            'Rim', 'Rol', 'Sachet', 'Set', 'Shot', 'Strip', 'Supp', 'Syringe',
            'Tablet', 'Tas', 'Tes', 'Tube', 'Unit', 'Vial', 'Zak'
        ],
        get filtered() {
            return this.items.filter(i =>
            i.toLowerCase().includes(this.search.toLowerCase())
            );
        },
        choose(item) {
            this.selected = item;
            this.search = item;
            this.open = false;
        }
        }
        }
     function multiselect() {
        return {
            open: false,
            search: '',
            // BARIS INI PALING PENTING UNTUK HALAMAN EDIT
            selected: @json(old('kategori', $product->kategori ?? [])),
            items: [
                'Analgesik', 'Anestetik', 'Antialergik', 'Antiasmatik', 'Antibiotik',
                'Antidiabetik', 'Antifungi', 'Antihipertensi', 'Antihistamin', 'Antiinflamasi',
                'Antikoagulan', 'Antiparasit', 'Antipiretik', 'Antiseptik', 'Antivirus',
                'Batuk dan pilek', 'Dislipidemik', 'Diuretik', 'Hemostatik', 'Hormon',
                'Keratolytik', 'Kontrasepsi', 'Lain lain', 'Nasal decongestion', 'Vaksin',
                'Vasodilator', 'Vitamin'
            ],
            get filtered() {
                return this.items.filter(i =>
                    !this.selected.includes(i) &&
                    i.toLowerCase().includes(this.search.toLowerCase())
                );
            },
            choose(item) {
                this.selected.push(item);
                this.search = '';
            },
            remove(item) {
                this.selected = this.selected.filter(i => i !== item);
            }
        }
    }

</script>
</x-app-layout>
