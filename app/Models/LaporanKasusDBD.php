<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKasusDBD extends Model
{
    use HasFactory;
    protected $table = "laporan_kasus_dbd";
    protected $guarded = ['id'];

}
