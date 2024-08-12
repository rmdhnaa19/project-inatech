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
        Schema::create('transaksi_alat', function (Blueprint $table) {
            $table->id('id_transaksi_alat');
            $table->string('kd_transaksi_alat',50)->unique();
            $table->enum('tipe_transaksi', ['masuk','keluar']);
            $table->bigInteger('quantity');
            $table->unsignedBigInteger('id_detail_alat')->index();
            $table->timestamps();

            $table->foreign('id_detail_alat')->references('id_detail_alat')->on('detail_alat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_alat');
    }
};
