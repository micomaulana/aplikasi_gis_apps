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
        Schema::create('pasiens', function (Blueprint $table) {
            $table->id();
            $table->string("nama");
            $table->string("alamat");
            $table->integer("usia");
            $table->string("id_desa");
            $table->string("provinsi");
            $table->string("kab_kota");
            $table->string("tempat_lahir");
            $table->string("tanggal_lahir");
            $table->string("jenis_kelamin");
            $table->string("Diagnosis_lab");
            $table->string("Diagnosis_klinis");
            $table->string("Status_akhir");
            $table->string('tahun_terdata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
};
