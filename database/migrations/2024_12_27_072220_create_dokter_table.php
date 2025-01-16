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
        Schema::create('dokter', function (Blueprint $table) {
            $table->id();
            $table->string("nama");
            $table->integer("nip");
            $table->string("status");
            $table->string("email")->unique();
            $table->string("alamat");
            $table->string("no_hp");
            $table->string("jenis_kelamin");
            $table->string("hari");
            $table->string("jam");
            $table->string("deskripsi")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokter');
    }
};
