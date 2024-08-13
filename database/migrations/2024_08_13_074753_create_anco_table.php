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
        Schema::create('anco', function (Blueprint $table) {
            $table->id('id_anco');
            $table->string('kd_anco',50)->unique();
            $table->date('tanggal_cek');
            $table->time('waktu_cek');
            $table->integer('pemberian_pakan');
            $table->time('jamPemberian_pakan');
            $table->string('kondisi_pakan');
            $table->string('kondisi_udang');
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
        Schema::dropIfExists('anco');
    }
};
