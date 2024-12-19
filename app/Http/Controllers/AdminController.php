<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Http\Request;
use Termwind\Components\Raw;

class AdminController extends Controller
{
    // panggil dashboard admin dan hitung jumlah poli, dokter, pasien
    public function showDashboard()
    {
        $jumlahPoli = Poli::count();
        $jumlahDokter = Dokter::count();
        $jumlahPasien = Pasien::count();
        $jumlahObat = Obat::count();

        return view(
            'admin.dashboard',
            compact('jumlahPoli', 'jumlahDokter', 'jumlahPasien', 'jumlahObat')
        );
    }

    // panggil halaman poi
    public function showPoli()
    {
        $poli = Poli::all();

        // kirim data ke view
        return view('admin.viewPoli', compact('poli'));
    }

    // panggil halaman dokter
    public function showDokter()
    {
        $dokter = Dokter::all();

        return view('admin.viewDokter', compact('dokter'));
    }

    // panggil halaman pasien
    public function showPasien()
    {
        $pasien = Pasien::all();

        return view('admin.viewPasien', compact('pasien'));
    }

    // panggil halaman edit poli tertentu
    public function editPoli($id)
    {
        $poli = Poli::findOrFail($id);
        return view('admin.editPoli', compact('poli'));
    }

    // update data poli
    public function updatePoli(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $poli = Poli::findOrFail($id);
        $poli->nama_poli = $request->input('nama');
        $poli->keterangan = $request->input('keterangan');
        $poli->save();

        return redirect()->route('admin.poli')->with('success', 'Data Poli berhasil diperbarui.');
    }

    // panggil halaman edit dokter tertentu
    public function editDokter($id)
    {
        $dokter = Dokter::findOrFail($id);
        $polis = Poli::all();

        return view('admin.editDokter', compact('dokter', 'polis'));
    }

    // update data dokter
    public function updateDokter(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:150',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max_digits:10',
            'poli_id' => 'required|integer',
        ]);

        $dokter = Dokter::findOrFail($id);
        $dokter->nama = $request->input('nama');
        $dokter->alamat = $request->input('alamat');
        $dokter->no_hp = $request->input('no_hp');
        $dokter->id_poli = $request->input('poli_id');
        $dokter->save();

        $user = User::where('name', $dokter->nama)->where('role', 'dokter')->first();
        if ($user) {
            $user->updated_at = now();
            $user->save();
        }

        return redirect()->route('admin.dokter')->with('success', 'Data Dokter berhasil diperbarui.');
    }

    // panggil halaman edit pasien tertentu
    public function editPasien($id)
    {
        $pasien = Pasien::findOrFail($id);

        return view('admin.editPasien', compact('pasien'));
    }

    // update data pasien
    public function updatePasien(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:150',
            'no_ktp' => 'required|string|max_digits:10',
            'no_hp' => 'required|string|max_digits:10',
            'no_rm' => 'required|string',
        ]);

        $pasien = Pasien::findOrFail($id);
        $pasien->nama = $request->input('nama');
        $pasien->no_ktp = $request->input('no_ktp');
        $pasien->no_hp = $request->input('no_hp');
        $pasien->no_rm = $request->input('no_rm');
        $pasien->save();

        $user = User::where('name', $pasien->nama)->where('role', 'pasien')->first();
        if ($user) {
            $user->updated_at = now();
            $user->save();
        }

        return redirect()->route('admin.pasien')->with('success', 'Data Pasien berhasil diperbarui.');
    }

    // panggil halaman add poli
    public function createPoli()
    {
        return view('admin.addPoli');
    }

    // add poli
    public function addPoli(Request $request)
    {
        $request->validate([
            'nama_poli' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $poli = new Poli;
        $poli->nama_poli = $request->input('nama_poli');
        $poli->keterangan = $request->input('keterangan');
        $poli->save();

        return redirect()->route('admin.poli')->with('success', 'Data Poli berhasil ditambahkan.');
    }

    // panggil halaman add dokter
    public function createDokter()
    {
        $polis = Poli::all();

        return view('admin.addDokter', compact('polis'));
    }

    // add dokter
    public function addDokter(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'nama_dokter' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max_digits:10',
            'id_poli' => 'required|integer',
        ]);

        $dokter = new Dokter();
        $dokter->nama = $request->input('nama_dokter');
        $dokter->alamat = $request->input('alamat');
        $dokter->no_hp = $request->input('no_hp');
        $dokter->id_poli = $request->input('id_poli');
        $dokter->save();

        User::create([
            'name' => $request->input('nama_dokter'),
            'email' => strtolower(str_replace(' ', '_', $request->input('nama_dokter'))) . "@gmail.com",
            'password' => '123',
            'role' => 'dokter',
        ]);

        return redirect()->route('admin.dokter')->with('success', 'Data Dokter berhasil ditambahkan.');
    }

    // panggil halaman add pasien
    public function createPasien()
    {
        return view('admin.addPasien');
    }

    // add pasien
    public function addPasien(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_ktp' => 'required|string|max_digits:10',
            'no_hp' => 'required|string|max_digits:10',
        ]);

        $currentYear = date('Y');
        $currentMonth = date('m');

        $lastPatient = Pasien::where('no_rm', 'LIKE', "$currentYear$currentMonth-%")
            ->orderBy('no_rm', 'desc')
            ->first();

        if ($lastPatient) {
            $lastNumber = (int) substr($lastPatient->no_rm, -3);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $no_rm = sprintf('%s%s-%03d', $currentYear, $currentMonth, $nextNumber);

        $pasien = new Pasien();
        $pasien->nama = $request->input('nama');
        $pasien->no_ktp = $request->input('no_ktp');
        $pasien->no_hp = $request->input('no_hp');
        $pasien->no_rm = $no_rm;
        $pasien->save();

        User::create([
            'name' => $request->input('nama'),
            'email' => strtolower(str_replace(' ', '_', $request->input('nama'))) . "@gmail.com",
            'password' => '123',
            'role' => 'pasien',
        ]);

        return redirect()->route('admin.pasien')->with('success', 'Data Pasien berhasil ditambahkan!');
    }

    // hapus poli
    public function hapusPoli($id)
    {
        $dokterCount = Dokter::where('id_poli', $id)->count();

        if ($dokterCount > 0) {
            return redirect()->route('admin.poli')->with('error', 'Tidak dapat menghapus Poli karena masih ada Dokter yang terkait.');
        }

        $poli = Poli::findOrFail($id);
        $poli->delete();

        return redirect()->route('admin.poli')->with('success', 'Data Poli berhasil dihapus.');
    }

    // hapus dokter
    public function hapusDokter($id)
    {
        $dokter = Dokter::findOrFail($id);
        $dokter->delete();

        return redirect()->route('admin.dokter')->with('success', 'Data Dokter berhasil dihapus.');
    }

    // hapus pasien
    public function hapusPasien($id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->delete();

        return redirect()->route('admin.pasien')->with('success', 'Data Pasien berhasil dihapus.');
    }

    // panggil halaman obat
    public function showObat()
    {
        $obat = Obat::all();

        return view('admin.viewObat', compact('obat'));
    }

    // panggil halaman tambah obat
    public function createObat()
    {
        return view('admin.addObat');
    }

    // panggil halaman edit obat
    public function editObat($id)
    {
        $obat = Obat::findOrFail($id);

        return view('admin.editObat', compact('obat'));
    }

    // add obat
    public function addObat(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kemasan' => 'nullable|string',
            'harga' => 'required|integer',
        ]);

        $obat = new Obat();
        $obat->nama_obat = $request->input('nama_obat');
        $obat->kemasan = $request->input('kemasan');
        $obat->harga = $request->input('harga');
        $obat->save();

        return redirect()->route('admin.obat')->with('success', 'Data Obat berhasil ditambahkan.');
    }

    // update obat
    public function updateObat(Request $request, $id)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kemasan' => 'nullable|string',
            'harga' => 'required|integer',
        ]);

        $obat = Obat::findOrFail($id);
        $obat->nama_obat = $request->input('nama_obat');
        $obat->kemasan = $request->input('kemasan');
        $obat->harga = $request->input('harga');
        $obat->save();

        return redirect()->route('admin.obat')->with('success', 'Data Obat berhasil diperbarui.');
    }

    // hapus obat
    public function hapusObat($id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();

        return redirect()->route('admin.obat')->with('success', 'Data Obat berhasil dihapus.');
    }
}
