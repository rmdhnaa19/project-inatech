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
        Schema::create('kualitas_air', function (Blueprint $table) {
            $table->id('kualitas_air');
            $table->string('kd_kualitas_air',50)->unique();
            $table->date('tanggal_cek');
            $table->time('waktu_cek');
            $table->integer('pH');
            $table->integer('salinitas');
            $table->integer('DO');
            $table->integer('suhu');
            $table->string('kejernihan_air', 50);
            $table->string('warna_air', 50);
            $table->text('catatan'); 
            $table->unsignedBigInteger('id_fase_tambak')->index();           
            $table->timestamps();

            $table->foreign('id_fase_tambak')->references('id_fase_tambak')->on('fase_tambak');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kualitas_air');
    }
};
