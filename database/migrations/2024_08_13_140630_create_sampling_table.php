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
        Schema::create('sampling', function (Blueprint $table) {
            $table->id('id_sampling');
            $table->string('kd_sampling',50)->unique();
            $table->date('tanggal_cek');
            $table->time('waktu_cek');
	        $table->integer('DOC');
            $table->integer('berat_udang');
            $table->integer('size_udang');
            $table->integer('interval_hari');
            $table->bigInteger('harga_udang');
            $table->integer('input_fr');
            $table->integer('total_pakan');
            $table->integer('ADG_udang');
            $table->integer('biomassa');
            $table->integer('populasi_ekor');
            $table->text('catatan');
            $table->unsignedBigInteger('id_fase_tambak')->index();
            $table->timestamps();
    
            $table->foreign('id_fase_tambak')->references('id_fase_tambakt')->on('fase_tambak');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sampling');
    }
};
