<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporaKasusDbd extends Model
{
    use HasFactory;
    protected $table = "laporan_kasus_dbd";
    protected $guarded = ['id'];

    public function pasien(){
        return $this->hasOne(Pasien::class,'id','id_pasien');
    }
}
