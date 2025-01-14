<php

public function hitungPeriksa(Request $request)  
{  
    /// Biaya jasa dokter  
    $biayaJasaDokter = 150000;  
  
    // Ambil data obat yang dipilih  
    $obatIds = $request->input('obat_ids'); // Misalnya, array ID obat yang dipilih  
    $totalBiayaObat = 0;  
  
    // Hitung total biaya obat  
    foreach ($obatIds as $id) {  
        $obat = Obat::find($id);  
        if ($obat) {  
            $totalBiayaObat += $obat->harga;  
        }  
    }  
  
    // Hitung total biaya periksa  
    $totalBiayaPeriksa = $biayaJasaDokter + $totalBiayaObat;  
  
    return response()->json([  
        'biaya_jasa_dokter' => $biayaJasaDokter,  
        'total_biaya_obat' => $totalBiayaObat,  
        'total_biaya_periksa' => $totalBiayaPeriksa  
    ]);  
}  
>?