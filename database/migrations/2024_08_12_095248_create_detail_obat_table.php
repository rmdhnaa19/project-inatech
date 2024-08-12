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
        Schema::create('detail_obat', function (Blueprint $table) {
            $table->id('id_detail_obat');
            $table->string('kd_detail_obat',50)->unique();
            $table->unsignedBigInteger('id_obat')->index();
            $table->unsignedBigInteger('id_gudang')->index();
            $table->bigInteger('stok_obat');
            $table->timestamps();

            $table->foreign('id_obat')->references('id_obat')->on('obat');
            $table->foreign('id_gudang')->references('id_gudang')->on('gudang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_obat');
    }
};
