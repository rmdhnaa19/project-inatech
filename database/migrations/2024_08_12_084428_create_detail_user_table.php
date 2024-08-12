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
        Schema::create('detail_user', function (Blueprint $table) {
            $table->id('id_detail_user');
            $table->string('kd_detail_user')->unique();
            $table->unsignedBigInteger('id_gudang')->index();
            $table->unsignedBigInteger('id_user')->index();
            $table->timestamps();

            $table->foreign('id_gudang')->references('id_gudang')->on('gudang');
            $table->foreign('id_user')->references('id_user')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_user');
    }
};
