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
        Schema::create('masajistas', function (Blueprint $table) {
            $table->integer('cedula')->primary();
            $table->string('nombre_masajista', 255);
            $table->string('telefono', 15);
            $table->timestamps();
        });    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('masajistas');
    }
};
