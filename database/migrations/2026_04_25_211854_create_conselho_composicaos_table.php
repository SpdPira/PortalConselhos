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
        Schema::create('conselho_composicaos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_conselho')->constrained('conselhos')->cascadeOnDelete();
            $table->string('nome');
            $table->string('funcao')->nullable();
            $table->string('segmento')->nullable();
            $table->date('vigencia_inicio')->nullable();
            $table->date('vigencia_fim')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conselho_composicaos');
    }
};
