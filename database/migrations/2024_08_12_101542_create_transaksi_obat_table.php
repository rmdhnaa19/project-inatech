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
        Schema::create('transaksi_obat', function (Blueprint $table) {
            $table->id('id_transaksi_obat');
            $table->string('kd_transaksi_obat',50)->unique();
            $table->enum('tipe_transaksi', ['masuk', 'keluar']);
            $table->bigInteger('quantity');
            $table->unsignedBigInteger('id_detail_obat')->index();
            $table->timestamps();

            $table->foreign('id_detail_obat')->references('id_detail_obat')->on('detail_obat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_obat');
    }
};
