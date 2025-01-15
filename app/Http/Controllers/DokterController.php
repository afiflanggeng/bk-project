<?php

namespace App\Http\Controllers;

use App\Models\DaftarPoli;
use App\Models\DetailPeriksa;
use App\Models\Dokter;
use App\Models\JadwalPeriksa;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Periksa;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function showDashboard(Request $request)
    {
        $listpasien = DaftarPoli::with('pasien', 'periksa')->get();
        $datadokter = array();
        foreach ($listpasien as $item) {
            $datae = JadwalPeriksa::where('id', '=', $item->id_jadwal)->first();
            array_push($datadokter, $datae->id_dokter);
        }
        $getnama = User::where("id","=",$request->session()->get("idlogin"))->first();
        $getdokter = Dokter::where("nama","=",$getnama->name)->first();
        return view('dokter.dokterlistperiksa', compact('listpasien', 'datadokter','getdokter'));
    }
    public function detailPemeriksaan(Request $request, $id)  
{  
    // Ambil detail pemeriksaan berdasarkan ID  
    $dataperiksa = Periksa::findOrFail($id);  
    $datapoli = DaftarPoli::with('pasien')->where("id", $dataperiksa->id_daftar_poli)->firstOrFail();  
    $dataobat = Obat::all(); // Ambil semua data obat  
  
    // Mengubah data obat menjadi opsi untuk dropdown  
    $valoption = $dataobat->map(function ($obat) {  
        return "<option value='{$obat->id}' data-harga='{$obat->harga}'>{$obat->nama_obat} - Rp. {$obat->harga}</option>";  
    })->join('');  
  
    return view('dokter.detailpemeriksaan', [  
        "datapoli" => $datapoli,  
        "dataobat" => $valoption  
    ]);  
}  
    public function simpantanggal(Request $request)
    {
        $databaru = new Periksa();
        $databaru->tgl_periksa = $request->tgl_periksa;
        $databaru->id_daftar_poli = $request->id_daftar_poli;
        $databaru->catatan = "";
        $databaru->save();
        return redirect()->route('dokter.dashboard');
    }
    public function simpanpemeriksaan(Request $request)  
{  
    $request->validate([  
        'idperiksa' => 'required|exists:periksa,id',  
        'catatan' => 'required|string',  
        'namaobat' => 'required|array|min:1',  
        'namaobat.*' => 'exists:obat,id',  
    ]);  
  
    // Simpan data pemeriksaan  
    $dataperiksa = Periksa::findOrFail($request->idperiksa);  
    $dataperiksa->update([  
        'catatan' => $request->catatan,  
        'biaya_periksa' => 150000 + array_sum(array_map(function($id) {  
            return Obat::find($id)->harga; // Ambil harga obat dari database  
        }, $request->namaobat)),  
    ]);  
  
    // Simpan detail obat  
    foreach ($request->namaobat as $idObat) {  
        DetailPeriksa::create([  
            'id_periksa' => $dataperiksa->id,  
            'id_obat' => $idObat,  
        ]);  
    }  
  
    return redirect()->route('dokter.history')->with('success', 'Data pemeriksaan berhasil disimpan.');  
}  
    public function historypasien()
    {
        $listpasien = DaftarPoli::with(['pasien', 'periksa'])
            ->get()
            ->filter(function ($item) {
                $jadwal = JadwalPeriksa::find($item->id_jadwal);
                return $jadwal && $jadwal->id_dokter === auth()->user()->id;
            });

        return view('dokter.dokterhistory', compact('listpasien'));
    }
    public function detailpasien(Request $request)
    {
        $datapasien = Pasien::with(['daftarPoli.periksa.detailPeriksa.obat'])
            ->findOrFail($request->id);

        $datasend = [
            "namapasien" => $datapasien->nama,
            "no_hp" => $datapasien->no_hp,
            "riwayat" => $datapasien->daftarPoli->map(function ($poli) {
                $periksa = $poli->periksa;
                return [
                    "catatan" => $periksa->catatan,
                    "tanggal" => $periksa->tgl_periksa,
                    "biaya" => $periksa->biaya_periksa,
                    "obat" => $periksa->detailPeriksa->map(fn($detail) => $detail->obat->nama_obat)->toArray(),
                ];
            }),
        ];

        return view('dokter.detailpasien', ["data" => $datasend]);
    }


    public function updateAkun(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'id_poli' => 'required|integer',
            'password' => 'nullable|string',
        ]);

        $user = auth()->user();

        $dokterLamaNama = $user->dokter ? $user->dokter->nama : null;

        $user->name = $request->input('nama');
        $user->password = $request->input('password');
        $user->email = $request->email;
        $user->save();

        if ($user->dokter) {
            $dokter = $user->dokter;
            $dokter->nama = $request->input('nama');
            $dokter->id_poli = $request->input('id_poli');
            $dokter->save();
        }

        session()->flash('dokter_lama_nama', $dokterLamaNama);

        return redirect()->route('dokter.dashboard')->with('success', 'Data Dokter berhasil diperbarui.');
    }

    public function showProfile(Request $request)
    {
        $userId = $request->session()->get('idlogin');

        \Log::info('User ID from session: ' . $userId);

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Session tidak ditemukan.');
        }

        $user = User::find($userId);

        if (!$user) {
            \Log::error('User tidak ditemukan dengan ID: ' . $userId);
            return redirect()->route('login')->with('error', 'User tidak ditemukan.');
        }

        $dokter = Dokter::where('nama', $user->name)->first();

        if (!$dokter) {
            \Log::error('Dokter tidak ditemukan dengan nama: ' . $user->name);
            return redirect()->route('login')->with('error', 'Data dokter tidak ditemukan.');
        }

        return view('dokter.pengaturan', [
            'dokter' => $dokter,
            'user' => $user,
            'polis' => Poli::all(),
        ]);
    }
    public function jadwaldokter(Request $request)
    {
        $getnama = User::where("id","=",$request->session()->get("idlogin"))->first();
        $getdokter = Dokter::where("nama","=",$getnama->name)->first();
        $datajadwal = JadwalPeriksa::where("id_dokter", "=", $getdokter->id)->get();
        foreach($datajadwal as $dd){
            if($dd->jam_mulai == "12:34:56"){
                $dd->jam_mulai = null;
                $dd->jam_selesai = null;
            }else{
                $arr = explode(":",$dd->jam_mulai);
                $dd->jam_mulai = $arr[0].":".$arr[1];
                $arr = explode(":",$dd->jam_selesai);
                $dd->jam_selesai = $arr[0].":".$arr[1];
            }
        }
        return view('dokter.jadwaldokter', ["datajadwal" => $datajadwal]);
    }
    public function simpanJadwal(Request $request)  
{  
    $request->validate([  
        'hari' => 'required',  
        'jam_mulai' => 'required',  
        'jam_selesai' => 'required',  
    ]);  
  
    $getnama = User::where("id", "=", session('idlogin'))->first();  
    $getdokter = Dokter::where("nama", "=", $getnama->name)->first();  
  
    // Nonaktifkan jadwal lain yang aktif untuk hari yang sama  
    $existingJadwal = JadwalPeriksa::where('hari', $request->input('hari'))  
        ->where('id_dokter', $getdokter->id)  
        ->get();  
  
    foreach ($existingJadwal as $jadwal) {  
        // Jika jam mulai dan jam selesai baru bertabrakan dengan jadwal yang ada  
        if (($request->input('jam_mulai') < $jadwal->jam_selesai) && ($request->input('jam_selesai') > $jadwal->jam_mulai)) {  
            // Nonaktifkan jadwal yang ada  
            $jadwal->aktif = false;  
            $jadwal->save();  
        }  
    }  
  
    // Simpan atau update jadwal baru  
    JadwalPeriksa::updateOrCreate(  
        ['hari' => $request->input('hari'), 'id_dokter' => $getdokter->id, 'jam_mulai' => $request->input('jam_mulai')],  
        [  
            'jam_selesai' => $request->input('jam_selesai'),  
            'aktif' => true // Jadwal baru diaktifkan  
        ]  
    );  
  
    return redirect()->route('dokter.lihatJadwal')->with('success', 'Jadwal berhasil disimpan.');  
}  

    public function lihatJadwal()  
{  
    $getnama = User::where("id", "=", session('idlogin'))->first();  
    $getdokter = Dokter::where("nama", "=", $getnama->name)->first();  
  
    // Ambil semua jadwal untuk dokter ini  
    $jadwal = JadwalPeriksa::where('id_dokter', $getdokter->id)->get();  
  
    return view('dokter.lihat_jadwal', compact('jadwal'));  
}  

public function updateJadwal(Request $request, $id)  
{  
    $jadwal = JadwalPeriksa::findOrFail($id);  
      
    // Jika status aktif diubah menjadi aktif  
    if ($request->input('aktif') == 1) {  
        // Nonaktifkan semua jadwal lain untuk hari yang sama  
        JadwalPeriksa::where('hari', $jadwal->hari)  
            ->where('id_dokter', $jadwal->id_dokter)  
            ->update(['aktif' => false]);  
    }  
  
    // Update status aktif  
    $jadwal->aktif = $request->input('aktif') == 1; // Mengubah status aktif  
    $jadwal->save();  
  
    return redirect()->route('dokter.lihatJadwal')->with('success', 'Status jadwal berhasil diperbarui.');  
}  


public function deleteJadwal($id)  
{  
    $jadwal = JadwalPeriksa::findOrFail($id);  
    $jadwal->delete();  
  
    return redirect()->route('dokter.lihatJadwal')->with('success', 'Jadwal berhasil dihapus.');  
}  

public function index($poli_id)  
{  
    // Ambil poli berdasarkan ID  
    $poli = Poli::findOrFail($poli_id);  
      
    // Ambil semua dokter yang terkait dengan poli  
    $dokters = Dokter::where('id_poli', $poli_id)->with('jadwalPeriksas')->get();  
      
    // Kembalikan view dengan data poli dan dokter  
    return view('pasien.pilih-dokter', compact('poli', 'dokters'));  
}  

    
}
