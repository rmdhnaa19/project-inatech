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
        Schema::create('kematian_udang', function (Blueprint $table) {
            $table->id('id_kematian_udang');
            $table->string('kd_kematian_udang',50)->unique();
            $table->integer('size_udang');
	        $table->integer('berat_udang');
            $table->text('catatan');
	        $table->string('gambar');
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
        Schema::dropIfExists('kematian_udang');
    }
};
