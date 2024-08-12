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
        Schema::create('user', function (Blueprint $table) {
            $table->id('id_user');
            $table->unsignedBigInteger('id_role')->index();
            $table->string('nama', 50)->unique();
            $table->string('no_hp', 12);
            $table->text('alamat');
            $table->bigInteger('gaji_pokok');
            $table->bigInteger('komisi');
            $table->bigInteger('tunjangan');
            $table->bigInteger('potongan_gaji');
            $table->string('posisi', 50);
            $table->timestamps();

            $table->foreign('id_role')->references('id_role')->on('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
