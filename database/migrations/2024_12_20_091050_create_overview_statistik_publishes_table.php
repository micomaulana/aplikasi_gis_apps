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
        Schema::create('overview_statistik_publishes', function (Blueprint $table) {
            $table->id();
            $table->integer("total_kasus");
            $table->integer("total_penduduk");
            $table->integer("total_desa_rawan");
            $table->integer("jumlah_desa");
            $table->string("tahun");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overview_statistik_publishes');
    }
};
