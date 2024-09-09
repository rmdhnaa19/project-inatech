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
            $table->string('foto', 255); 
            $table->string('nama_tambak', 50)->unique(); 
            $table->string('id_gudang');
            $table->integer('luas_lahan'); 
            $table->integer('luas_tambak');
            $table->text('lokasi_tambak'); 
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
