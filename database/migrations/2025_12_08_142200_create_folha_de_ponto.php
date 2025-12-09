<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('folha_ponto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('funcionario_id')->constrained('funcionarios')->onDelete('cascade');
            $table->integer('mes'); // 1-12
            $table->integer('ano'); // 2024, 2025...
            $table->json('registros'); // Array com dados dos 31 dias
            $table->boolean('fechada')->default(false);
            $table->timestamps();

            $table->unique(['funcionario_id', 'mes', 'ano']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('folha_ponto');
    }
};
