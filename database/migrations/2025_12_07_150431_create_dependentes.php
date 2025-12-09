<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dependentes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('funcionario_id')->constrained('funcionarios')->onDelete('cascade');
            $table->string('nome');
            $table->date('data_nascimento');
            $table->enum('tipo', ['filho', 'filha', 'conjuge', 'outro'])->default('filho');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dependentes');
    }
};