<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->unsignedBigInteger('id_cita')->primary();
            $table->dateTime('fecha');

            $table->integer('masajista');
            $table->integer('id_cliente');

            $table->text('nota')->nullable();

            $table->enum('estado', ['pendiente', 'confirmada', 'cancelada', 'finalizada']);
            $table->integer('habitacion');

            $table->timestamps();


            $table->foreign('id_cliente')->references('cedula')->on('clientes')->onDelete('cascade');
            $table->foreign('masajista')->references('cedula')->on('masajistas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
