<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('galeria_imagens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('galeria_id')->constrained()->cascadeOnDelete();
            $table->string('ruta'); // path del storage
            $table->string('titulo')->nullable();
            $table->string('alt_text')->nullable();
            $table->unsignedInteger('orden')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galeria_imagens');
    }
};
