<x-app-layout>
    <div class="max-w-3xl mx-auto py-12">
        <div class="bg-white p-8 rounded-2xl shadow-lg">
            
            {{-- HEADER FORM --}}
            <div class="pb-6 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800">Edit Data Poli</h1>
                <p class="mt-1 text-sm text-gray-500">Ubah nama poli dan sesuaikan daftar dokter yang bertugas.</p>
            </div>

            <form method="POST" action="{{ route('polis.update', $poli->id_poli) }}" class="mt-6">
                @csrf
                @method('PUT')
                <div class="space-y-8">
                    <div>
                        <x-input-label for="nama_poli" value="Nama Poli" class="font-semibold" />
                         <p class="mt-1 text-sm text-gray-500">Contoh: Poli Gigi, Poli Umum, Poli Jantung.</p>
                        <x-text-input id="nama_poli" class="block mt-2 w-full" type="text" name="nama_poli" :value="old('nama_poli', $poli->nama_poli)" required autofocus />
                        <x-input-error :messages="$errors->get('nama_poli')" class="mt-2" />
                    </div>

                    <div 
                        x-data='{
                            open: false,
                            search: "",
                            selected: @json(old("doctors") ? collect($doctorsForSelect)->whereIn("id", old("doctors"))->values() : $selectedDoctors),
                            items: @json($doctorsForSelect),

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
                    >
                        <x-input-label for="doctors-select" value="Dokter Bertugas" class="font-semibold" />
                        <p class="mt-1 text-sm text-gray-500">Anda bisa mengubah daftar dokter yang bertugas di poli ini.</p>
                        
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
                                    @keydown.enter.prevent="choose(filtered[0])"
                                    class="flex-grow border-0 focus:ring-0 text-sm"
                                    placeholder="Cari dokter untuk ditambahkan..."
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
                
                {{-- FOOTER FORM --}}
                <div class="flex items-center justify-end pt-6 mt-6 border-t border-gray-200">
                    <a href="{{ route('polis.index') }}" class="text-sm text-gray-600 hover:text-gray-800 mr-4">Batal</a>
                    <x-primary-button>
                        Update Poli
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>