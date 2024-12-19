<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';
    protected $fillable = ['nama', 'no_ktp', 'no_hp', 'no_rm'];
    public $timestamps = false;

    /**
     * Relasi ke model DaftarPoli.
     * Pasien memiliki banyak Daftar Poli.
     */
    public function daftarPolis()
    {
        return $this->hasMany(DaftarPoli::class, 'id_pasien');
    }
}
