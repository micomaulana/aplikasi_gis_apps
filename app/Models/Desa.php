<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Model Desa
    public function pasien()
    {
        return $this->hasMany(Pasien::class, 'id_desa');
    }
}
