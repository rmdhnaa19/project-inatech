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
        Schema::create('user_tambak', function (Blueprint $table) {
            $table->id('id_user_tambak');
            $table->string('kd_user_tambak',50)->unique();
            $table->unsignedBigInteger('id_user')->index();
            $table->unsignedBigInteger('id_tambak')->index();
            $table->timestamps();
            
            
            $table->foreign('id_user')->references('id_user')->on('user');
            $table->foreign('id_tambak')->references('id_tambak')->on('tambak');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_tambak');
    }
};
