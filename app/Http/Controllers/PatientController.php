<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Pasien;
use App\Models\Poli;
use App\Models\Dokter;
use App\Models\Pendaftaran;
use App\Models\JadwalPeriksa;
use App\Models\DaftarPoli;


class PatientController extends Controller
{
    public function showRegisterForm()
    {
        return view('register');
    }

    public function showDashboardPasien()
    {
        return view(
            'pasien.dashboard_pasien',
        );
    }

    public function showLoginPasienForm()
    {
        return view('login_pasien');
    }

    // proses login pasien
    public function doLoginPasien(Request $request)
    {
        $request->validate([
            'name_or_nr_medis' => 'required', // Input bisa berupa nama atau nr_medis
            'password' => 'required'
        ]);

        // Cari user berdasarkan nama atau nr_medis
        $user = User::where('name', $request->name_or_nr_medis)
            ->orWhere('nr_medis', $request->name_or_nr_medis)
            ->first();

        // Periksa apakah user ditemukan dan password cocok
        if (!$user || $user->password !== $request->password) {
            return back()->with('error', 'Nama/Nr Medis atau password salah.');
        }

        // Log the user in
        Auth::login($user);

        // Redirect based on the user's role
        if ($user->role === 'pasien') {
            session(['pasien_name' => $user->name]);  // Store pasien's name in session
            return redirect()->route('pasien.pilih-poli');
        } else if ($user->role === 'dokter') {
            return redirect()->route('dokter.dashboard');
        } else {
            return redirect()->route('admin.dashboard');
        }

        // Redirect to login page if no valid role
        return redirect()->route('showLoginPage');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string',
            'password' => 'required|string',
            'no_ktp' => 'required|integer',
            'no_hp' => 'required|integer',
        ]);

        // Periksa apakah no_ktp sudah terdaftar
        $existingUser = Pasien::where('no_ktp', $request->no_ktp)->first();
        if ($existingUser) {
            return redirect()->back()->withErrors(['no_ktp' => 'Nomor KTP sudah terdaftar.']);
        } else {
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = $request->input('password');
            $user->role = "pasien";
            $user->created_at = now();
            $user->updated_at = now();
            $user->save();


            // Simpan data pasien baru ke tabel Pasien
            $pasien = new Pasien;
            $pasien->nama = $request->input('name');
            $pasien->no_ktp = $request->input('no_ktp');
            $pasien->no_hp = $request->input('no_hp');
            $pasien->save();
        }

        return redirect()->route('login_pasien')->with('success', 'Registration successful. Please log in.');
    }

    // Function to generate a unique no_rm
    private function generateNoRm()
    {
        $currentYearMonth = now()->format('Ym'); // Example: 202411
        $patientsCount = Pasien::count();
        return 'RM-' . $currentYearMonth . '-' . str_pad($patientsCount + 1, 3, '0', STR_PAD_LEFT);
    }

    // Halaman memilih poli
    public function pilihPoli()
    {
        $polis = Poli::all(); // Ambil semua poli
        $pasien_name = session('pasien_name');  // Ambil nama pasien dari session
        return view('pasien.pilih-poli', compact('polis', 'pasien_name'));
    }

    // Halaman memilih dokter setelah memilih poli
    public function pilihDokter(Request $request, Poli $poli)
    {
        $pasien_name = $request->pasien_name;  // Ambil nama pasien yang dikirim melalui URL
        $pasien = Pasien::where('nama', $pasien_name)->first();  // Cari pasien berdasarkan nama

        if (!$pasien) {
            return redirect()->route('pasien.pilih-poli')->with('error', 'Pasien tidak ditemukan.');
        }

        $dokters = $poli->dokters()->with('jadwalPeriksas')->get();

        return view('pasien.pilih-dokter', compact('poli', 'dokters', 'pasien', 'pasien_name'));
    }

    public function pilihDokterSubmit(Request $request, Poli $poli)
    {
        // Validasi input dari form
        $request->validate([
            'dokter_id' => 'required|exists:dokter,id',
            'jadwal_id' => 'required|exists:jadwal_periksa,id',
            'keluhan' => 'required',
        ]);

        // Ambil nama pasien dari session atau parameter
        $pasien_name = session('pasien_name');

        // Cari pasien berdasarkan nama
        $pasien = Pasien::where('nama', $pasien_name)->first();

        if (!$pasien) {
            return redirect()->route('pasien.pilih-poli')->with('error', 'Pasien tidak ditemukan.');
        }

        // Ambil data dokter dan jadwal yang dipilih
        $dokter = Dokter::findOrFail($request->dokter_id);
        $jadwal = JadwalPeriksa::findOrFail($request->jadwal_id);

        // Hitung nomor antrean berdasarkan jadwal
        $antreanTerakhir = DaftarPoli::where('id_jadwal', $jadwal->id)->max('no_antrian');
        $nomorAntrian = $antreanTerakhir ? $antreanTerakhir + 1 : 1;

        // Daftarkan pasien ke daftar poli
        DaftarPoli::create([
            'id_pasien' => $pasien->id,
            'id_jadwal' => $jadwal->id,
            'no_antrian' => $nomorAntrian,
            'keluhan' => $request->input('keluhan'),
        ]);

        // Redirect ke halaman jadwal pasien dengan pesan sukses
        return redirect()->route('pasien.jadwal')->with('success', 'Anda berhasil mendaftar ke poli. Nomor antrean Anda: ' . $nomorAntrian);
    }

    public function lihatJadwal(Request $request)
    {
        // Ambil nama pasien dari session
        $pasien_name = session('pasien_name');

        // Cari pasien berdasarkan nama
        $pasien = Pasien::where('nama', $pasien_name)->first();

        // Periksa apakah pasien ditemukan
        if (!$pasien) {
            return redirect()->route('pasien.pilih-poli')->with('error', 'Pasien tidak ditemukan.');
        }

        // Ambil semua daftar poli yang terkait dengan pasien
        $daftarPolis = DaftarPoli::where('id_pasien', $pasien->id)
            ->get();

        // Mengirimkan data ke view
        return view('pasien.jadwal', compact('daftarPolis'));
    }
}
