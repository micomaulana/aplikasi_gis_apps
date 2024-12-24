<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporan_foggings', function (Blueprint $table) {
            $table->id();
            $table->integer("id_desa");
            $table->integer("jumlah_kasus");
            $table->string("tanggal_pengajuan");
            $table->string("tanggal_persetujuan")->nullable();
            $table->string("keterangan");
            $table->string("status_pengajuan");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_foggings');
    }
};
