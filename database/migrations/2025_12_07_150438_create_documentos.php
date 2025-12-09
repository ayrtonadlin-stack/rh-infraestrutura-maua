<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('funcionario_id')->constrained('funcionarios')->onDelete('cascade');
            $table->enum('tipo', [
                'fotos_3x4',
                'rg',
                'cpf',
                'pis_pasep',
                'ctps',
                'certidao_casamento_nascimento',
                'certidao_nascimento_dependentes',
                'comprovante_residencia',
                'declaracao_escolaridade',
                'certificado_reservista',
                'titulo_eleitor',
                'certidao_quitacao_eleitoral',
                'comprovante_dados_bancarios',
                'antecedentes_estadual',
                'antecedentes_federal'
            ]);
            $table->string('arquivo_nome');
            $table->string('arquivo_path');
            $table->string('arquivo_mime')->nullable();
            $table->integer('arquivo_tamanho')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
