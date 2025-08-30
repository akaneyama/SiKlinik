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
    public function index()
    {
        $patients = Patient::with('membership')->latest()->paginate(15);
        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    // Fungsi helper untuk validasi agar tidak duplikat kode
    private function validatePatient(Request $request, Patient $patient = null)
    {
        $emailRule = ['nullable', 'email', 'max:255'];
        $identityRule = ['nullable', 'string', 'max:255'];

        if ($patient) { // Saat update
            $emailRule[] = Rule::unique('patients', 'email')->ignore($patient->id_pasien, 'id_pasien');
            $identityRule[] = Rule::unique('patients', 'no_identitas')->ignore($patient->id_pasien, 'id_pasien');
        } else { // Saat create
            $emailRule[] = 'unique:patients,email';
            $identityRule[] = 'unique:patients,no_identitas';
        }

        return $request->validate([
            'nama_pasien' => ['required', 'string', 'max:255'],
            'jenis_identitas' => ['nullable', Rule::in(['KTP', 'SIM', 'Paspor', 'Lainnya'])],
            'no_identitas' => $identityRule,
            'tempat_lahir' => ['nullable', 'string', 'max:255'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jenis_kelamin' => ['nullable', Rule::in(['Laki-laki', 'Perempuan'])],
            'gol_darah' => ['nullable', Rule::in(['A', 'B', 'AB', 'O', 'Tidak Tahu'])],
            'agama' => ['nullable', 'string', 'max:255'],
            'etnis' => ['nullable', 'string', 'max:255'],
            'kewarganegaraan' => ['nullable', 'string', 'max:255'],
            'tingkat_pendidikan' => ['nullable', 'string', 'max:255'],
            'pekerjaan' => ['nullable', 'string', 'max:255'],
            'email' => $emailRule,
            'nomor_telp' => ['nullable', 'string', 'max:255'],
            'whatsapp' => ['nullable', 'string', 'max:255'],
            'telepon_domisili' => ['nullable', 'string', 'max:255'],
            'alamat_domisili' => ['nullable', 'string'],
            'desa_kelurahan' => ['nullable', 'string', 'max:255'],
            'kecamatan' => ['nullable', 'string', 'max:255'],
            'kota' => ['nullable', 'string', 'max:255'],
            'provinsi' => ['nullable', 'string', 'max:255'],
            'kode_pos' => ['nullable', 'string', 'max:255'],
            'kerabat_pasien' => ['nullable', 'string', 'max:255'],
            'hubungan_kerabat' => ['nullable', 'string', 'max:255'],
            'no_telp_kerabat' => ['nullable', 'string', 'max:255'],
            'id_lama' => ['nullable', 'string', 'max:255'],
            'perusahaan' => ['nullable', 'string', 'max:255'],
            'alamat_perusahaan' => ['nullable', 'string'],
            'telepon_perusahaan' => ['nullable', 'string', 'max:255'],
            'jenis_keanggotaan' => ['nullable', 'string', 'max:255'],
            'keanggotaan_kadaluarsa' => ['nullable', 'date'],
            'insurances' => ['nullable', 'array'],
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $this->validatePatient($request);

        try {
            DB::transaction(function () use ($request, $validatedData) {
                $membershipId = null;
                if ($request->filled('jenis_keanggotaan')) {
                    $membership = Membership::create([
                        'jenis_keanggotaan' => $request->jenis_keanggotaan,
                        'keanggotaan_kadaluarsa' => $request->keanggotaan_kadaluarsa,
                    ]);
                    $membershipId = $membership->id_keanggotaan;
                }
                
                // Gunakan $validatedData agar lebih aman
                $patientData = $validatedData;
                $patientData['id_keanggotaan'] = $membershipId;
                $patient = Patient::create($patientData);

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

                        $patient->insurances()->attach($insurance->id_asuransi, [
                            'status_hubungan' => $asuransiData['status_hubungan'],
                            'nomor_kartu_pasien' => $asuransiData['nomor_kartu_pasien'],
                        ]);
                    }
                }
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
        }

        return redirect()->route('patients.index')->with('success', 'Data pasien baru berhasil ditambahkan.');
    }

    public function show(Patient $patient)
    {
        $patient->load('membership', 'insurances');
        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        $patient->load('membership', 'insurances');
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validatedData = $this->validatePatient($request, $patient);

        try {
            DB::transaction(function () use ($request, $patient, $validatedData) {
                if ($request->filled('jenis_keanggotaan')) {
                    if ($patient->membership) {
                        $patient->membership->update([
                            'jenis_keanggotaan' => $request->jenis_keanggotaan,
                            'keanggotaan_kadaluarsa' => $request->keanggotaan_kadaluarsa,
                        ]);
                    } else {
                        $membership = Membership::create([
                            'jenis_keanggotaan' => $request->jenis_keanggotaan,
                            'keanggotaan_kadaluarsa' => $request->keanggotaan_kadaluarsa,
                        ]);
                        $validatedData['id_keanggotaan'] = $membership->id_keanggotaan;
                    }
                } else {
                    if ($patient->membership) {
                        $patient->membership->delete();
                    }
                    $validatedData['id_keanggotaan'] = null;
                }
                
                $patient->update($validatedData);

                $syncData = [];
                if ($request->has('insurances')) {
                    foreach ($request->insurances as $asuransiData) {
                        if (empty($asuransiData['no_polis'])) continue; // Lewati jika no polis kosong
                        $insurance = Insurance::updateOrCreate(
                            ['no_polis' => $asuransiData['no_polis']],
                            [
                                'nama_asuransi' => $asuransiData['nama_asuransi'],
                                'jenis_asuransi' => $asuransiData['jenis_asuransi'],
                                'nama_pemegang_polis' => $asuransiData['nama_pemegang_polis'],
                            ]
                        );
                        $syncData[$insurance->id_asuransi] = [
                            'status_hubungan' => $asuransiData['status_hubungan'],
                            'nomor_kartu_pasien' => $asuransiData['nomor_kartu_pasien'],
                        ];
                    }
                }
                $patient->insurances()->sync($syncData);
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())->withInput();
        }

        return redirect()->route('patients.index')->with('success', 'Data pasien berhasil diperbarui.');
    }

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
