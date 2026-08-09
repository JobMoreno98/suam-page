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
        Schema::create('configuracion_sitios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('acerca_de');
            $table->json('codigo_etica');
            $table->json('contacto');
            $table->string('dictamen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracion_sitios');
    }
};
