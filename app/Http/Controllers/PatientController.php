<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Membership;
use App\Models\Insurance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{
    /**
     * Menampilkan daftar semua pasien.
     */
    public function index()
    {
        $patients = Patient::with('membership')->latest()->paginate(15);
        return view('patients.index', compact('patients'));
    }

    /**
     * Menampilkan form untuk membuat pasien baru.
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Menyimpan data pasien baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi data akan kita tambahkan nanti saat membuat view
        // Untuk sekarang kita fokus pada logika penyimpanan

        // Gunakan DB Transaction untuk memastikan semua data konsisten.
        // Jika salah satu gagal, semua akan dibatalkan (rollback).
        try {
            DB::transaction(function () use ($request) {
                // 1. Urus Keanggotaan (Membership)
                $membershipId = null;
                if ($request->filled('jenis_keanggotaan')) {
                    $membership = Membership::create([
                        'jenis_keanggotaan' => $request->jenis_keanggotaan,
                        'keanggotaan_kadaluarsa' => $request->keanggotaan_kadaluarsa,
                    ]);
                    $membershipId = $membership->id_keanggotaan;
                }

                // 2. Buat data Pasien utama
                $patient = Patient::create([
                    'nama_pasien' => $request->nama_pasien,
                    'no_identitas' => $request->no_identitas,
                    'jenis_identitas' => $request->jenis_identitas,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'gol_darah' => $request->gol_darah,
                    'agama' => $request->agama,
                    'email' => $request->email,
                    'nomor_telp' => $request->nomor_telp,
                    // ... isi semua kolom lain dari $request
                    'id_keanggotaan' => $membershipId,
                ]);

                // 3. Urus Asuransi (bisa lebih dari satu)
                if ($request->has('insurances')) {
                    foreach ($request->insurances as $asuransiData) {
                        // Cari atau buat baru data polis asuransi
                        $insurance = Insurance::updateOrCreate(
                            ['no_polis' => $asuransiData['no_polis']], // Kunci untuk mencari
                            [ // Data untuk diisi jika tidak ada atau diupdate
                                'nama_asuransi' => $asuransiData['nama_asuransi'],
                                'jenis_asuransi' => $asuransiData['jenis_asuransi'],
                                'nama_pemegang_polis' => $asuransiData['nama_pemegang_polis'],
                            ]
                        );

                        // Hubungkan pasien dengan asuransi di tabel pivot
                        $patient->insurances()->attach($insurance->id_asuransi, [
                            'status_hubungan' => $asuransiData['status_hubungan'],
                            'nomor_kartu_pasien' => $asuransiData['nomor_kartu_pasien'],
                        ]);
                    }
                }
            });
        } catch (\Exception $e) {
            // Jika terjadi error, kembalikan ke halaman sebelumnya dengan pesan error
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
        }

        return redirect()->route('patients.index')->with('success', 'Data pasien baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu pasien (jika diperlukan).
     */
    public function show(Patient $patient)
    {
        $patient->load('membership', 'insurances');
        return view('patients.show', compact('patient'));
    }

    /**
     * Menampilkan form untuk mengedit data pasien.
     */
    public function edit(Patient $patient)
    {
        $patient->load('membership', 'insurances');
        return view('patients.edit', compact('patient'));
    }

    /**
     * Memperbarui data pasien di database.
     */
    public function update(Request $request, Patient $patient)
    {
        // Validasi data akan kita tambahkan nanti

        try {
            DB::transaction(function () use ($request, $patient) {
                // 1. Urus Keanggotaan (Membership)
                if ($request->filled('jenis_keanggotaan')) {
                    if ($patient->membership) {
                        // Jika sudah ada, update
                        $patient->membership->update([
                            'jenis_keanggotaan' => $request->jenis_keanggotaan,
                            'keanggotaan_kadaluarsa' => $request->keanggotaan_kadaluarsa,
                        ]);
                    } else {
                        // Jika belum ada, buat baru dan hubungkan
                        $membership = Membership::create([
                            'jenis_keanggotaan' => $request->jenis_keanggotaan,
                            'keanggotaan_kadaluarsa' => $request->keanggotaan_kadaluarsa,
                        ]);
                        $patient->id_keanggotaan = $membership->id_keanggotaan;
                    }
                } else {
                    // Jika dikosongkan, hapus relasi keanggotaan
                    $patient->id_keanggotaan = null;
                }

                // 2. Update data Pasien utama
                $patient->update($request->except(['insurances', 'jenis_keanggotaan', 'keanggotaan_kadaluarsa']));
                $patient->save();

                // 3. Urus Asuransi dengan metode sync()
                $syncData = [];
                if ($request->has('insurances')) {
                    foreach ($request->insurances as $asuransiData) {
                        $insurance = Insurance::updateOrCreate(
                            ['no_polis' => $asuransiData['no_polis']],
                            [
                                'nama_asuransi' => $asuransiData['nama_asuransi'],
                                'jenis_asuransi' => $asuransiData['jenis_asuransi'],
                                'nama_pemegang_polis' => $asuransiData['nama_pemegang_polis'],
                            ]
                        );
                        // Siapkan data untuk sync
                        $syncData[$insurance->id_asuransi] = [
                            'status_hubungan' => $asuransiData['status_hubungan'],
                            'nomor_kartu_pasien' => $asuransiData['nomor_kartu_pasien'],
                        ];
                    }
                }
                // Sync akan otomatis menambah, mengupdate, dan menghapus relasi asuransi
                $patient->insurances()->sync($syncData);
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())->withInput();
        }

        return redirect()->route('patients.index')->with('success', 'Data pasien berhasil diperbarui.');
    }

    /**
     * Menghapus data pasien dari database.
     */
    public function destroy(Patient $patient)
    {
        try {
            // Relasi ke asuransi akan terhapus otomatis karena onDelete('cascade')
            // Relasi ke membership akan menjadi null karena onDelete('set null')
            // Jika membership ingin ikut terhapus, kita bisa hapus manual
            if ($patient->membership) {
                $patient->membership->delete();
            }
            $patient->delete();
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data pasien.');
        }

        return redirect()->route('patients.index')->with('success', 'Data pasien berhasil dihapus.');
    }
}
