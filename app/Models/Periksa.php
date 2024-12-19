<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periksa extends Model
{
    use HasFactory;
    protected $table = 'periksa';
    public $timestamps = false;
    protected $fillable = [
        'id_daftar_poli',
        'tgl_periksa',
        'catatan',
        'biaya_periksa',
    ];
    public function daftarpoli(){
        return $this->hasOne(DaftarPoli::class,'id_daftar_poli');
    }
    public function detailperiksa(){
        return $this->belongsTo(DetailPeriksa::class,'id');
    }
}
