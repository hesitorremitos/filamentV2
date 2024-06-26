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
        Schema::create('menciones_DA', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->foreignId('carrera_id')->constrained('carreras');
            $table->timestamps();
        });

        Schema::create('diplomas_academicos', function (Blueprint $table) {
            $table->unsignedInteger('nro_documento')->primary();
            $table->date('fecha_emision')->nullable();
            $table->integer('fojas');
            $table->integer('nro_libro');
            $table->string('nivel')->default('Licenciatura')->nullable();
            $table->string('path',500)->nullable();
            $table->string('persona_ci',255);
            $table->foreignId('mencion_id')->constrained('menciones_DA');
            $table->foreignId('carrera_id')->constrained('carreras');
            $table->timestamps();

            $table->foreign('persona_ci')->references('ci')->on('personas');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menciones_DA');
        Schema::dropIfExists('diplomas_academicos');
    }
};
