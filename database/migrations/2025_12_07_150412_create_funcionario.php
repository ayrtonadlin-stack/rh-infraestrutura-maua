<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->id();

            // Identificação
            $table->string('matricula')->unique();
            $table->string('nome_completo');
            $table->string('funcao');
            $table->enum('status', ['pendente', 'ativo', 'inativo', 'rejeitado'])->default('pendente');

            // Documentação Básica
            $table->string('cpf', 14)->unique();
            $table->string('rg_numero');
            $table->string('rg_orgao_emissor');
            $table->date('rg_data_expedicao')->nullable();
            $table->date('data_nascimento');
            $table->string('nacionalidade')->default('Brasileira');
            $table->enum('estado_civil', ['solteiro', 'casado', 'divorciado', 'viuvo', 'uniao_estavel']);

            // Endereço
            $table->string('endereco_logradouro');
            $table->string('endereco_numero');
            $table->string('endereco_bairro');
            $table->string('endereco_cep', 9);
            $table->string('endereco_municipio');
            $table->string('endereco_uf', 2);

            // Contato
            $table->string('telefone_fixo')->nullable();
            $table->string('telefone_celular');
            $table->string('email')->nullable();

            // Documentação Legal
            $table->string('pis_pasep')->nullable();
            $table->string('ctps_numero')->nullable();
            $table->string('ctps_serie')->nullable();
            $table->string('titulo_eleitor')->nullable();
            $table->string('titulo_zona')->nullable();
            $table->string('titulo_secao')->nullable();
            $table->string('cnh_numero')->nullable();
            $table->string('cnh_categoria')->nullable();
            $table->string('certificado_reservista')->nullable();

            // Dados Adicionais
            $table->string('grau_instrucao')->nullable();
            $table->string('nome_pai')->nullable();
            $table->string('nome_mae')->nullable();
            $table->string('filiacao_uf', 2)->nullable();

            // Uniforme
            $table->string('uniforme_camisa')->nullable();
            $table->string('uniforme_calca')->nullable();

            // Dados Bancários
            $table->string('banco')->nullable();
            $table->string('agencia')->nullable();
            $table->string('conta')->nullable();

            // Controle
            $table->string('equipe')->nullable();
            $table->string('distrito')->default('5º Distrito de Infraestrutura');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('funcionarios');
    }
};
