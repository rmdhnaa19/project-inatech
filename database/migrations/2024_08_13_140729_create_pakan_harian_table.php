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
        Schema::create('pakan_harian', function (Blueprint $table) {
            $table->id('id_pakan_harian');
            $table->string('kd_pakan_harian',50)->unique();
            $table->date('tanggal_cek');
            $table->time('waktu_cek');
	        $table->integer('DOC');
            $table->integer('berat_udang');
	        $table->integer('total_pakan');
	        $table->text('catatan');
            $table->unsignedBigInteger('id_fase_tambak')->index();
            $table->unsignedBigInteger('id_detail_pakan')->index();
            $table->timestamps();
    
            $table->foreign('id_fase_tambak')->references('id_fase_tambak')->on('fase_tambak');
            $table->foreign('id_detail_pakan')->references('id_detail_pakan')->on('detail_pakan');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pakan_harian');
    }
};
