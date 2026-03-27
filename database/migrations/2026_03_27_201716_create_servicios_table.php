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
    Schema::create('servicios', function (Blueprint $table) {
        $table->unsignedBigInteger('id_servicio')->primary();
        $table->string('nombre_servicio', 255);
        $table->integer('precio');
        $table->string('descripcion', 255);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};
