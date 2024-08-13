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
        Schema::create('penanganan', function (Blueprint $table) {
            $table->id('id_penanganan');
            $table->string('kd_penanganan',50)->unique();
            $table->date('tanggal_cek');
            $table->time('waktu_cek');
            $table->integer('pemberian_mineral');
            $table->integer('pemberian_vitamin');
            $table->integer('pemberian_obat');
            $table->integer('penambahan_air');
            $table->integer('pengurangan_air');
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
        Schema::dropIfExists('penanganan');
    }
};
