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
    public function detailPemeriksaan(Request $request)
    {
        $dataperiksa = Periksa::where("id", "=", $request->id)->first();
        $datapoli = DaftarPoli::where("id", "=", $dataperiksa->id_daftar_poli)->with('pasien')->get();
        $dataobat = Obat::all();
        $valoption = "";
        foreach ($dataobat as $data) {
            $valoption .= '<option value="' . $data->id . '">' . $data->nama_obat . '</option>';
        }
        return view('dokter.detailpemeriksaan', ["datapoli" => $datapoli, "dataobat" => $valoption]);
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
        $dataperiksa = Periksa::where("id", "=", $request->idperiksa)->first();
        $dataperiksa->catatan = $request->catatan;
        $dataperiksa->biaya_periksa = $request->nominal;
        $dataperiksa->save();
        foreach ($request->namaobat as $data) {
            $dataobat = new DetailPeriksa();
            $dataobat->id_periksa = $request->idperiksa;
            $dataobat->id_obat = $data;
            $dataobat->save();
        }
        // echo $dataperiksa;
        return redirect()->route('dokter.dashboard');
    }
    public function historypasien()
    {
        $listpasien = DaftarPoli::with('pasien', 'periksa')->get();
        $datadokter = array();
        foreach ($listpasien as $item) {
            $datae = JadwalPeriksa::where('id', '=', $item->id_jadwal)->first();
            array_push($datadokter, $datae->id_dokter);
        }
        return view('dokter.dokterhistory', compact('listpasien', 'datadokter'));
    }
    public function detailpasien(Request $request)
    {
        $datasend = array();
        $datapasien = Pasien::where("id", "=", $request->id)->first();
        $datapolis = DaftarPoli::where("id_pasien", "=", $datapasien->id)->get();
        $datasend["namapasien"] = $datapasien->nama;
        $datasend["no_hp"] = $datapasien->no_hp;
        $datapushtmp = array();
        foreach ($datapolis as $data) {
            $datapush = array();
            $dataperiksa = Periksa::where("id_daftar_poli", "=", $data->id)->first();
            $datapush["catatan"] = $dataperiksa->catatan;
            $datapush["tanggal"] = $dataperiksa->tgl_periksa;
            $datapush["biaya"] = $dataperiksa->biaya_periksa;
            $datadetail = DetailPeriksa::where("id_periksa", "=", $dataperiksa->id)->get();
            $lobat = array();
            foreach ($datadetail as $dataa) {
                $obate = Obat::where("id", "=", $dataa->id_obat)->first();
                array_push($lobat, $obate->nama_obat);
            }
            $datapush["obat"] = $lobat;
            array_push($datapushtmp, $datapush);
        }
        $datasend["riwayat"] = $datapushtmp;
        return view('dokter.detailpasien', ["data" => $datasend]);
    }

    public function updateAkun(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'id_poli' => 'required|integer',
            'password' => 'nullable|string',
        ]);

        $user = auth()->user();

        $dokterLamaNama = $user->dokter ? $user->dokter->nama : null;

        $user->name = $request->input('nama');
        $user->password = $request->input('password');
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
    public function simpanjadwal(Request $request)
    {
        $getnama = User::where("id","=",$request->session()->get("idlogin"))->first();
        $getdokter = Dokter::where("nama","=",$getnama->name)->first();
        $cekjadwal = JadwalPeriksa::where("id_dokter", "=", $getdokter->id)->get();
        if (count($cekjadwal) == 0) {
            if ($request->jam[0] != "") {
                if ($request->jam[1] == "") {
                    return redirect()->route('dokter.jadwaldokter');
                }
                $simpan = new JadwalPeriksa();
                $simpan->id_dokter = $getdokter->id;
                $simpan->hari = "senin";
                $simpan->jam_mulai = $request->jam[0];
                $simpan->jam_selesai = $request->jam[1];
                $simpan->save();
            }else{
                $simpan = new JadwalPeriksa();
                $simpan->id_dokter = $getdokter->id;
                $simpan->hari = "senin";
                $simpan->jam_mulai = "12:34:56";
                $simpan->jam_selesai = "12:34:56";
                $simpan->save();
            }
            if ($request->jam[2] != "") {
                if ($request->jam[3] == "") {
                    return redirect()->route('dokter.jadwaldokter');
                }
                $simpan = new JadwalPeriksa();
                $simpan->id_dokter = $getdokter->id;
                $simpan->hari = "selasa";
                $simpan->jam_mulai = $request->jam[2];
                $simpan->jam_selesai = $request->jam[3];
                $simpan->save();
            }else{
                $simpan = new JadwalPeriksa();
                $simpan->id_dokter = $getdokter->id;
                $simpan->hari = "selasa";
                $simpan->jam_mulai = "12:34:56";
                $simpan->jam_selesai = "12:34:56";
                $simpan->save();
            }
            if ($request->jam[4] != "") {
                if ($request->jam[5] == "") {
                    return redirect()->route('dokter.jadwaldokter');
                }
                $simpan = new JadwalPeriksa();
                $simpan->id_dokter = $getdokter->id;
                $simpan->hari = "rabu";
                $simpan->jam_mulai = $request->jam[4];
                $simpan->jam_selesai = $request->jam[5];
                $simpan->save();
            }else{
                $simpan = new JadwalPeriksa();
                $simpan->id_dokter = $getdokter->id;
                $simpan->hari = "rabu";
                $simpan->jam_mulai = "12:34:56";
                $simpan->jam_selesai = "12:34:56";
                $simpan->save();
            }
            if ($request->jam[6] != "") {
                if ($request->jam[7] == "") {
                    return redirect()->route('dokter.jadwaldokter');
                }
                $simpan = new JadwalPeriksa();
                $simpan->id_dokter = $getdokter->id;
                $simpan->hari = "kamis";
                $simpan->jam_mulai = $request->jam[6];
                $simpan->jam_selesai = $request->jam[7];
                $simpan->save();
            }else{
                $simpan = new JadwalPeriksa();
                $simpan->id_dokter = $getdokter->id;
                $simpan->hari = "kamis";
                $simpan->jam_mulai = "12:34:56";
                $simpan->jam_selesai = "12:34:56";
                $simpan->save();
            }
            if ($request->jam[8] != "") {
                if ($request->jam[9] == "") {
                    return redirect()->route('dokter.jadwaldokter');
                }
                $simpan = new JadwalPeriksa();
                $simpan->id_dokter = $getdokter->id;
                $simpan->hari = "jumat";
                $simpan->jam_mulai = $request->jam[8];
                $simpan->jam_selesai = $request->jam[9];
                $simpan->save();
            }else{
                $simpan = new JadwalPeriksa();
                $simpan->id_dokter = $getdokter->id;
                $simpan->hari = "jumat";
                $simpan->jam_mulai = "12:34:56";
                $simpan->jam_selesai = "12:34:56";
                $simpan->save();
            }
        } else {
            if ($request->jam[0] != "") {
                if ($request->jam[1] == "") {
                    return redirect()->route('dokter.jadwaldokter');
                }
                $simpan = $simpan = JadwalPeriksa::where("hari", "=", "senin", "and")->where("id_dokter", "=", $getdokter->id)->first();;
                $simpan->id_dokter = $getdokter->id;
                $simpan->jam_mulai = $request->jam[0];
                $simpan->jam_selesai = $request->jam[1];
                $simpan->save();
            }else{
                $simpan = $simpan = JadwalPeriksa::where("hari", "=", "senin", "and")->where("id_dokter", "=", $getdokter->id)->first();;
                $simpan->id_dokter = $getdokter->id;
                $simpan->jam_mulai = "12:34:56";
                $simpan->jam_selesai = "12:34:56";
                $simpan->save();
            }
            if ($request->jam[2] != "") {
                if ($request->jam[3] == "") {
                    return redirect()->route('dokter.jadwaldokter');
                }
                $simpan = $simpan = JadwalPeriksa::where("hari", "=", "selasa", "and")->where("id_dokter", "=", $getdokter->id)->first();;
                $simpan->id_dokter = $getdokter->id;
                $simpan->jam_mulai = $request->jam[2];
                $simpan->jam_selesai = $request->jam[3];
                $simpan->save();
            }else{
                $simpan = $simpan = JadwalPeriksa::where("hari", "=", "selasa", "and")->where("id_dokter", "=", $getdokter->id)->first();;
                $simpan->id_dokter = $getdokter->id;
                $simpan->jam_mulai = "12:34:56";
                $simpan->jam_selesai = "12:34:56";
                $simpan->save();
            }
            if ($request->jam[4] != "") {
                if ($request->jam[5] == "") {
                    return redirect()->route('dokter.jadwaldokter');
                }
                $simpan = $simpan = JadwalPeriksa::where("hari", "=", "rabu", "and")->where("id_dokter", "=", $getdokter->id)->first();;
                $simpan->id_dokter = $getdokter->id;
                $simpan->jam_mulai = $request->jam[4];
                $simpan->jam_selesai = $request->jam[5];
                $simpan->save();
            }else{
                $simpan = $simpan = JadwalPeriksa::where("hari", "=", "rabu", "and")->where("id_dokter", "=", $getdokter->id)->first();;
                $simpan->id_dokter = $getdokter->id;
                $simpan->jam_mulai = "12:34:56";
                $simpan->jam_selesai = "12:34:56";
                $simpan->save();
            }
            if ($request->jam[6] != "") {
                if ($request->jam[7] == "") {
                    return redirect()->route('dokter.jadwaldokter');
                }
                $simpan = $simpan = JadwalPeriksa::where("hari", "=", "kamis", "and")->where("id_dokter", "=", $getdokter->id)->first();;
                $simpan->id_dokter = $getdokter->id;
                $simpan->jam_mulai = $request->jam[6];
                $simpan->jam_selesai = $request->jam[7];
                $simpan->save();
            }else{
                $simpan = $simpan = JadwalPeriksa::where("hari", "=", "kamis", "and")->where("id_dokter", "=", $getdokter->id)->first();;
                $simpan->id_dokter = $getdokter->id;
                $simpan->jam_mulai = "12:34:56";
                $simpan->jam_selesai = "12:34:56";
                $simpan->save();
            }
            if ($request->jam[8] != "") {
                if ($request->jam[9] == "") {
                    return redirect()->route('dokter.jadwaldokter');
                }
                $simpan = $simpan = JadwalPeriksa::where("hari", "=", "jumat", "and")->where("id_dokter", "=", $getdokter->id)->first();;
                $simpan->id_dokter = $getdokter->id;
                $simpan->jam_mulai = $request->jam[8];
                $simpan->jam_selesai = $request->jam[9];
                $simpan->save();
            }else{
                $simpan = $simpan = JadwalPeriksa::where("hari", "=", "jumat", "and")->where("id_dokter", "=", $getdokter->id)->first();;
                $simpan->id_dokter = $getdokter->id;
                $simpan->jam_mulai = "12:34:56";
                $simpan->jam_selesai = "12:34:56";
                $simpan->save();
            }
        }
        return redirect()->route('dokter.jadwaldokter');
    }
}
