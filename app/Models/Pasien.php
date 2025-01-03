<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function desa()
    {
        return $this->hasOne(Desa::class, 'id', 'id_desa');
    }
}
