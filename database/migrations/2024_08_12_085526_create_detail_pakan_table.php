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
        Schema::create('detail_pakan', function (Blueprint $table) {
            $table->id('id_detail_pakan');
            $table->string('kd_detail_pakan', 50)->unique();
            $table->unsignedBigInteger('id_pakan')->index();
            $table->unsignedBigInteger('id_gudang')->index();
            $table->bigInteger('stok_pakan');
            $table->timestamps();

            $table->foreign('id_pakan')->references('id_pakan')->on('pakan');
            $table->foreign('id_gudang')->references('id_gudang')->on('gudang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pakan');
    }
};
