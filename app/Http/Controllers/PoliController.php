<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use App\Models\Doctor;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    public function index()
    {
        // Menampilkan daftar poli beserta jumlah dokter di masing-masing poli
        $polis = Poli::withCount('doctors')->latest()->paginate(10);
        return view('polis.index', compact('polis'));
    }
    

    public function create()
    {
        // Ambil semua dokter untuk ditampilkan di form
        $doctors = Doctor::orderBy('nama_dokter')->get();
        // dd($doctors); 

        return view('polis.create', compact('doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_poli' => 'required|string|max:255|unique:polis,nama_poli',
            'doctors' => 'nullable|array', // 'doctors' adalah nama input dari form
            'doctors.*' => 'exists:doctors,id_dokter', // Memastikan setiap id dokter valid
        ]);

        // Buat data poli baru
        $poli = Poli::create(['nama_poli' => $validated['nama_poli']]);

        // Hubungkan dokter yang dipilih ke poli yang baru dibuat
        if (!empty($validated['doctors'])) {
            $poli->doctors()->attach($validated['doctors']);
        }

        return redirect()->route('polis.index')->with('success', 'Poli baru berhasil ditambahkan.');
    }

    public function edit(Poli $poli)
    {
        $poli->load('doctors');
        $allDoctors = Doctor::orderBy('nama_dokter')->get();
    
        // Siapkan data untuk komponen multiselect di view
        // 1. Semua dokter dalam format { id, text }
        $doctorsForSelect = $allDoctors->map(function ($doctor) {
            return ['id' => $doctor->id_dokter, 'text' => $doctor->nama_dokter . ' (' . $doctor->spesialisasi . ')'];
        });
    
        // 2. Dokter yang sudah terpilih dalam format yang sama
        $selectedDoctors = $poli->doctors->map(function ($doctor) {
            return ['id' => $doctor->id_dokter, 'text' => $doctor->nama_dokter . ' (' . $doctor->spesialisasi . ')'];
        });
    
        return view('polis.edit', compact('poli', 'doctorsForSelect', 'selectedDoctors'));
    }

    public function update(Request $request, Poli $poli)
    {
        $validated = $request->validate([
            'nama_poli' => 'required|string|max:255|unique:polis,nama_poli,' . $poli->id_poli . ',id_poli',
            'doctors' => 'nullable|array',
            'doctors.*' => 'exists:doctors,id_dokter',
        ]);

        // Update nama poli
        $poli->update(['nama_poli' => $validated['nama_poli']]);

        // Sinkronkan daftar dokter. `sync` akan otomatis menambah/menghapus relasi.
        $poli->doctors()->sync($validated['doctors'] ?? []);

        return redirect()->route('polis.index')->with('success', 'Data poli berhasil diperbarui.');
    }

    public function destroy(Poli $poli)
    {
        // Hapus semua relasi di tabel pivot sebelum menghapus poli
        $poli->doctors()->detach();
        $poli->delete();

        return redirect()->route('polis.index')->with('success', 'Data poli berhasil dihapus.');
    }
}