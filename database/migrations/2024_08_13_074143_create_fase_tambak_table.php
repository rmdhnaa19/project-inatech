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
        Schema::create('fase_tambak', function (Blueprint $table) {
            $table->id('id_fase_tambak');
            $table->string('kd_fase_tambak',50)->unique();
            $table->date('tanggal_mulai');
            $table->date('tanggal_panen');
            $table->integer('jumlah_tebar');
            $table->integer('densitas');
            $table->unsignedBigInteger('id_kolam')->index();
            $table->timestamps();

            $table->foreign('id_kolam')->references('id_kolam')->on('kolam');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fase_tambak');
    }
};
