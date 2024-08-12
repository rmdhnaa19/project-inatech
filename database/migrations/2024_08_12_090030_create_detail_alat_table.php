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
        Schema::create('detail_alat', function (Blueprint $table) {
            $table->id('id_detail_alat');
            $table->string('kd_detail_alat', 50)->unique();
            $table->unsignedBigInteger('id_alat')->index();
            $table->unsignedBigInteger('id_gudang')->index();
            $table->bigInteger('stok_alat');
            $table->timestamps();

            $table->foreign('id_alat')->references('id_alat')->on('alat');
            $table->foreign('id_gudang')->references('id_gudang')->on('gudang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_alat');
    }
};
