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
        Schema::create('statistiks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_desa');
            $table->enum('status',['tinggi','sedang','rendah']);
            $table->string('jumlah_kasus');
            $table->string('jumlah_penduduk');
            $table->string('tanggal_fogging');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistiks');
    }
};
