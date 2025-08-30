<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Manajemen Poli</h1>
                <a href="{{ route('polis.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Tambah Poli
                </a>
            </div>

            {{-- Notifikasi Sukses --}}
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 border-l-4 border-green-500 rounded-md shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Poli</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Dokter</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokter Bertugas</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Aksi</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($polis as $poli)
                                    <tr class="hover:bg-gray-100 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $poli->nama_poli }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $poli->doctors_count }} Dokter
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex flex-wrap gap-1 max-w-xs">
                                                @forelse($poli->doctors as $doctor)
                                                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full font-semibold">{{ $doctor->nama_dokter }}</span>
                                                @empty
                                                    <span class="text-xs text-gray-400">Belum ada dokter yang ditugaskan</span>
                                                @endforelse
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-4">
                                                <a href="{{ route('polis.edit', $poli->id_poli) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <form action="{{ route('polis.destroy', $poli->id_poli) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus poli ini? Semua relasi dengan dokter akan dihapus.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                            Tidak ada data poli ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Link Paginasi --}}
                    @if ($polis->hasPages())
                        <div class="mt-6 px-2">
                            {{ $polis->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>