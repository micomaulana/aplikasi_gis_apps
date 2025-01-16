<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;
    protected $table = "dokter";
    protected $guarded = ['id'];
    protected $fillable = [
        'nama',
        'nip',
        'status',
        'email',
        'alamat',
        'no_hp',
        'jenis_kelamin',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'deskripsi'
    ];
}
