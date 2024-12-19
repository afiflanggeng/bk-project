<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $table = 'obat';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_obat',
        'kemasan',
        'harga',
    ];

    public $timestamps = false;
    public function detailperiksa(){
        return $this->hasOne(DetailPeriksa::class,'id');
    }
}
