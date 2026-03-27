<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    /**
     * Run the migrations.
     */
    public function up()    {
        Schema::create('masa_servicio', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_servicio');
            $table->integer('id_masajista');

            $table->integer('comision');

            $table->timestamps();

            $table->foreign('id_servicio')->references('id_servicio')->on('servicios')->onDelete('cascade');
            $table->foreign('id_masajista')->references('cedula')->on('masajistas')->onDelete('cascade');
        });    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('masa_servicio');
    }
};
