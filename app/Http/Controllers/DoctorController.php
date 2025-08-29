<?php
// app/Http/Controllers/DoctorController.php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use App\Models\JadwalPraktek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('user')->latest()->paginate(10);
        return view('doctors.index', compact('doctors'));
    }

    public function create()
    {
        // Ambil user dengan role 'dokter' yang BELUM memiliki profil dokter
        $users = User::where('role', 'dokter')->whereDoesntHave('doctor')->pluck('name', 'id');
        return view('doctors.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => ['required', 'exists:users,id', 'unique:doctors,id_user'],
            'nama_dokter' => ['required', 'string', 'max:255'],
            'no_str' => ['required', 'string', 'max:255', 'unique:doctors,no_str'],
            'spesialisasi' => ['required', 'string', 'max:255'],
            'jadwal' => ['required', 'array', 'min:1'],
            'jadwal.*.hari' => ['required', Rule::in(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'])],
            'jadwal.*.jam_mulai' => ['required', 'date_format:H:i'],
            'jadwal.*.jam_selesai' => ['required', 'date_format:H:i', 'after:jadwal.*.jam_mulai'],
        ]);

        DB::transaction(function () use ($request) {
            $doctor = Doctor::create($request->only('id_user', 'nama_dokter', 'no_str', 'spesialisasi'));

            foreach ($request->jadwal as $jadwal) {
                $doctor->jadwalPraktek()->create($jadwal);
            }
        });

        return redirect()->route('doctors.index')->with('success', 'Data dokter berhasil ditambahkan.');
    }

    public function edit(Doctor $doctor)
    {
        $doctor->load('jadwalPraktek'); // Eager load jadwal
        return view('doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            // id_user tidak bisa diubah
            'nama_dokter' => ['required', 'string', 'max:255'],
            'no_str' => ['required', 'string', 'max:255', Rule::unique('doctors')->ignore($doctor->id_dokter, 'id_dokter')],
            'spesialisasi' => ['required', 'string', 'max:255'],
            'jadwal' => ['required', 'array', 'min:1'],
            'jadwal.*.hari' => ['required', Rule::in(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'])],
            'jadwal.*.jam_mulai' => ['required', 'date_format:H:i'],
            'jadwal.*.jam_selesai' => ['required', 'date_format:H:i', 'after:jadwal.*.jam_mulai'],
        ]);

        DB::transaction(function () use ($request, $doctor) {
            $doctor->update($request->only('nama_dokter', 'no_str', 'spesialisasi'));

            // Hapus jadwal lama dan buat yang baru (cara paling simpel untuk update)
            $doctor->jadwalPraktek()->delete();

            foreach ($request->jadwal as $jadwal) {
                $doctor->jadwalPraktek()->create($jadwal);
            }
        });

        return redirect()->route('doctors.index')->with('success', 'Data dokter berhasil diperbarui.');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctors.index')->with('success', 'Data dokter berhasil dihapus.');
    }
}
