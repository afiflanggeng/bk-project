<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $table = 'dokter';
    protected $fillable = ['nama', 'alamat', 'no_hp', 'id_poli'];

    // Nonaktifkan timestamps
    public $timestamps = false;

    /**
     * Relasi ke model Poli.
     * Dokter dimiliki oleh satu Poli.
     */
    public function poli()
    {
        return $this->belongsTo(Poli::class, 'id_poli');
    }

    /**
     * Relasi ke model JadwalPeriksa.
     * Dokter memiliki banyak Jadwal Periksa.
     */
    public function jadwalPeriksas()
    {
        return $this->hasMany(JadwalPeriksa::class, 'id_dokter');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'nama', 'name');
    }
}
