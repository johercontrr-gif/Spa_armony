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
    Schema::create('citas_servicios', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('id_servicio');
        $table->unsignedBigInteger('id_cita');

        $table->integer('duracion');

        $table->timestamps();

        $table->foreign('id_servicio')->references('id_servicio')->on('servicios')->onDelete('cascade');
        $table->foreign('id_cita')->references('id_cita')->on('citas')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas_servicios');
    }
};
