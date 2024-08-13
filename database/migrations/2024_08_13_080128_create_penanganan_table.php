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
            $table->string('kd_kolam',50)->unique();
            $table->enum('tipe_kolam', ['kotak', 'bundar']);
            $table->integer('panjang_kolam');
            $table->integer('lebar_kolam');
            $table->integer('luas_kolam');
            $table->integer('kedalaman');
            $table->unsignedBigInteger('id_tambak')->index();
            $table->timestamps();
    
            $table->foreign('id_tambak')->references('id_tambakt')->on('tambak');
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
