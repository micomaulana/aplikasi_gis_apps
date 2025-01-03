<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OverviewStatistikPublish extends Model
{
    use HasFactory;
    protected $table = "overview_statistik_publishes";
    protected $guarded = ['id'];
    public function desa(){
        return $this->hasOne(Desa::class,'id','id_desa');
    }
}
