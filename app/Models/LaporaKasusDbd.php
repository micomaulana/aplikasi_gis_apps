<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporaKasusDbd extends Model
{
    use HasFactory;
    protected $table = "laporan_kasus_dbd";
    protected $guarded = ['id'];
    protected $fillable = [
        'id_pasien',
        'gejala_yang_dialami',
        'gejala_lain',
        'file_hasil_lab',
        'status',
        'no_tiket',
        'jadwal_control',
        'dokter_pj'
    ];

    public function pasien(){
        return $this->hasOne(Pasien::class,'id','id_pasien');
    }
    public function dokter(){
        return $this->hasOne(Dokter::class,'id','dokter_pj');
    }
}
