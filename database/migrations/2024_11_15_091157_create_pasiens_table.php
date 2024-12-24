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
            $table->string("email")->unique();
            $table->integer("usia");
            $table->string("id_desa");
            $table->string("provinsi");
            $table->string("kab_kota");
            $table->string("tempat_lahir");
            $table->string("tanggal_lahir");
            $table->string("jenis_kelamin");
            $table->string("diagnosis_lab")->nullable();
            $table->string("diagnosis_klinis")->nullable();
            $table->string("status_akhir")->nullable();
            $table->string("no_hp");
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
