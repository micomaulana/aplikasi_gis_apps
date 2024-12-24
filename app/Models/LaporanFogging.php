<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanFogging extends Model
{
    use HasFactory;
    protected $table = "laporan_foggings";
    protected $guarded = ['id'];

    public function desa(){
        return $this->hasOne(Desa::class,'id','id_desa');
    }
}
