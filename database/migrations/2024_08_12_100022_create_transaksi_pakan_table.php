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
        Schema::create('transaksi_pakan', function (Blueprint $table) {
            $table->id('id_transaksi_pakan');
            $table->string('kd_transaksi_pakan',50)->unique();
            $table->enum('tipe_transaksi', ['masuk','keluar']);
            $table->bigInteger('quantity');
            $table->unsignedBigInteger('id_detail_pakan')->index();
            $table->timestamps();

            $table->foreign('id_detail_pakan')->references('id_detail_pakan')->on('detail_pakan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_pakan');
    }
};
