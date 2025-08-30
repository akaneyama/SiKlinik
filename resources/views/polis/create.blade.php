<x-app-layout>
    <div class="max-w-3xl mx-auto py-12">
        
        <div class="bg-white p-8 rounded-2xl shadow-lg">
            
        
            <div class="pb-6 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800">Formulir Data Poli</h1>
                <p class="mt-1 text-sm text-gray-500">Buat poli baru dan tugaskan dokter yang akan melayani di poli tersebut.</p>
            </div>

            <form method="POST" action="{{ route('polis.store') }}" class="mt-6">
                @csrf
                <div class="space-y-8">
                    <div>
                        <x-input-label for="nama_poli" value="Nama Poli" class="font-semibold" />
                        <p class="mt-1 text-sm text-gray-500">Contoh: Poli Gigi, Poli Umum, Poli Jantung.</p>
                        <x-text-input id="nama_poli" class="block mt-2 w-full" type="text" name="nama_poli" :value="old('nama_poli')" required autofocus />
                        <x-input-error :messages="$errors->get('nama_poli')" class="mt-2" />
                    </div>

                    <div 
                        x-data='{
                            open: false,
                            search: "",
                            selected: [],
                            items: @json(
                                $doctors->map(function($doctor) {
                                    return ["id" => $doctor->id_dokter, "text" => $doctor->nama_dokter . " (" . $doctor->spesialisasi . ")"];
                                })
                            ),
                            
                            init() {
                                const oldDoctors = @json(old("doctors", []));
                                if (oldDoctors.length > 0) {
                                    this.selected = this.items.filter(item => oldDoctors.map(String).includes(String(item.id)));
                                }
                            },

                            get filtered() {
                                if (this.search === "") { return this.items.filter(item => !this.selected.map(s => s.id).includes(item.id)); }
                                return this.items.filter(item =>
                                    !this.selected.map(s => s.id).includes(item.id) &&
                                    item.text.toLowerCase().includes(this.search.toLowerCase())
                                );
                            },
                            choose(item) {
                                if (typeof item === "undefined") return;
                                this.selected.push(item);
                                this.search = "";
                                this.open = false;
                            },
                            remove(item) {
                                this.selected = this.selected.filter(i => i.id !== item.id);
                            }
                        }'
                        x-init='init()'
                    >
                        <x-input-label for="doctors-select" value="Dokter Bertugas" class="font-semibold" />
                        <p class="mt-1 text-sm text-gray-500">Anda bisa memilih lebih dari satu dokter. Klik untuk mencari.</p>
                        
                        <template x-for="item in selected" :key="item.id">
                            <input type="hidden" name="doctors[]" :value="item.id">
                        </template>

                        <div class="relative mt-2" @click.outside="open = false">
                            <div class="w-full flex flex-wrap gap-2 p-2 border border-gray-300 rounded-md shadow-sm min-h-[42px] bg-white">
                                <template x-for="item in selected" :key="item.id">
                                    <span class="flex items-center gap-1 bg-indigo-100 text-indigo-800 text-sm font-medium px-2 py-0.5 rounded-full">
                                        <span x-text="item.text"></span>
                                        <button type="button" @click="remove(item)" class="font-bold text-indigo-500 hover:text-indigo-700">&times;</button>
                                    </span>
                                </template>
                                <input 
                                    type="text" 
                                    x-model="search"
                                    @focus="open = true"
                                    style="border:none; outline:none; box-shadow:none;"
                                    @keydown.enter.prevent="choose(filtered[0])"
                                   class="flex-grow border-0 outline-none focus:ring-0 focus:border-0 text-sm"
                                    placeholder="Cari dokter..."
                                >
                            </div>
                            <div x-show="open" x-transition class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto">
                                <template x-for="item in filtered" :key="item.id">
                                    <div @click="choose(item)"
                                         class="px-3 py-2 cursor-pointer hover:bg-gray-100 text-sm"
                                         x-text="item.text">
                                    </div>
                                </template>
                                <div x-show="filtered.length === 0 && search.length > 0" class="px-3 py-2 text-sm text-gray-400">
                                    Tidak ada hasil ditemukan.
                                </div>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('doctors')" class="mt-2" />
                    </div>
                </div>
           
                <div class="flex items-center justify-end pt-6 mt-6 border-t border-gray-200">
                    <a href="{{ route('polis.index') }}" class="text-sm text-gray-600 hover:text-gray-800 mr-4">Batal</a>
                    <x-primary-button>
                        Simpan Poli
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>