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
        Schema::create('tambak', function (Blueprint $table) {
            $table->id('id_tambak');
            $table->string('gambar', 100); // Kolom gambar dengan panjang varchar 50
            $table->string('nama_tambak', 50)->unique(); //kolom tambak
            $table->integer('luas_lahan'); // Kolom luas_lahan tipe integer
            $table->integer('luas_tambak'); // Kolom luas_tambak tipe integer
            $table->text('lokasi_tambak'); // Kolom lokasi_tambak tipe text
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tambak');
    }
};
