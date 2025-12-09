<?php

namespace Database\Seeders;

use App\Models\Funcionario;
use App\Models\Dependente;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FuncionarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Funcionário 1 - Ativo
        $func1 = Funcionario::create([
            'matricula' => 'MG000001',
            'nome_completo' => 'João da Silva Santos',
            'funcao' => 'Auxiliar Administrativo',
            'status' => 'ativo',
            'cpf' => '123.456.789-00',
            'rg_numero' => '12.345.678-9',
            'rg_orgao_emissor' => 'SSP/RJ',
            'rg_data_expedicao' => '2015-03-15',
            'data_nascimento' => '1985-06-20',
            'nacionalidade' => 'Brasileira',
            'estado_civil' => 'casado',
            'endereco_logradouro' => 'Rua das Flores',
            'endereco_numero' => '123',
            'endereco_bairro' => 'Centro',
            'endereco_cep' => '25900-000',
            'endereco_municipio' => 'Magé',
            'endereco_uf' => 'RJ',
            'telefone_fixo' => '(21) 2633-1234',
            'telefone_celular' => '(21) 98765-4321',
            'email' => 'joao.silva@email.com',
            'pis_pasep' => '120.12345.67-8',
            'ctps_numero' => '12345',
            'ctps_serie' => '678',
            'titulo_eleitor' => '1234 5678 9012',
            'titulo_zona' => '025',
            'titulo_secao' => '0100',
            'cnh_numero' => '12345678900',
            'cnh_categoria' => 'AB',
            'certificado_reservista' => '123456',
            'grau_instrucao' => 'medio_completo',
            'nome_pai' => 'José Santos',
            'nome_mae' => 'Maria Silva Santos',
            'filiacao_uf' => 'RJ',
            'uniforme_camisa' => 'M',
            'uniforme_calca' => '42',
            'banco' => 'Banco do Brasil',
            'agencia' => '1234-5',
            'conta' => '12345-6',
            'equipe' => 'Equipe A',
            'distrito' => '5º Distrito de Infraestrutura',
        ]);

        // Adicionar dependentes
        Dependente::create([
            'funcionario_id' => $func1->id,
            'nome' => 'Maria da Silva Santos',
            'data_nascimento' => '2010-08-15',
            'tipo' => 'filha',
        ]);

        Dependente::create([
            'funcionario_id' => $func1->id,
            'nome' => 'Pedro da Silva Santos',
            'data_nascimento' => '2015-03-20',
            'tipo' => 'filho',
        ]);

        // Funcionário 2 - Pendente
        Funcionario::create([
            'matricula' => 'MG000002',
            'nome_completo' => 'Ana Paula Oliveira',
            'funcao' => 'Assistente de RH',
            'status' => 'pendente',
            'cpf' => '987.654.321-00',
            'rg_numero' => '98.765.432-1',
            'rg_orgao_emissor' => 'SSP/RJ',
            'data_nascimento' => '1990-12-10',
            'nacionalidade' => 'Brasileira',
            'estado_civil' => 'solteiro',
            'endereco_logradouro' => 'Avenida Brasil',
            'endereco_numero' => '456',
            'endereco_bairro' => 'Vila Nova',
            'endereco_cep' => '25900-100',
            'endereco_municipio' => 'Magé',
            'endereco_uf' => 'RJ',
            'telefone_celular' => '(21) 99876-5432',
            'email' => 'ana.oliveira@email.com',
            'grau_instrucao' => 'superior_completo',
            'nome_pai' => 'Carlos Oliveira',
            'nome_mae' => 'Beatriz Oliveira',
            'filiacao_uf' => 'RJ',
        ]);

        // Funcionário 3 - Ativo
        Funcionario::create([
            'matricula' => 'MG000003',
            'nome_completo' => 'Carlos Eduardo Mendes',
            'funcao' => 'Técnico em Infraestrutura',
            'status' => 'ativo',
            'cpf' => '456.789.123-00',
            'rg_numero' => '45.678.912-3',
            'rg_orgao_emissor' => 'SSP/RJ',
            'rg_data_expedicao' => '2018-07-22',
            'data_nascimento' => '1988-04-18',
            'nacionalidade' => 'Brasileira',
            'estado_civil' => 'divorciado',
            'endereco_logradouro' => 'Rua dos Trabalhadores',
            'endereco_numero' => '789',
            'endereco_bairro' => 'Industrial',
            'endereco_cep' => '25900-200',
            'endereco_municipio' => 'Magé',
            'endereco_uf' => 'RJ',
            'telefone_celular' => '(21) 97654-3210',
            'email' => 'carlos.mendes@email.com',
            'pis_pasep' => '130.13456.78-9',
            'ctps_numero' => '23456',
            'ctps_serie' => '789',
            'cnh_numero' => '23456789011',
            'cnh_categoria' => 'D',
            'grau_instrucao' => 'medio_completo',
            'nome_pai' => 'Eduardo Mendes',
            'nome_mae' => 'Fernanda Mendes',
            'filiacao_uf' => 'RJ',
            'uniforme_camisa' => 'G',
            'uniforme_calca' => '44',
            'banco' => 'Caixa Econômica Federal',
            'agencia' => '5678-9',
            'conta' => '98765-4',
            'equipe' => 'Equipe B',
            'distrito' => '5º Distrito de Infraestrutura',
        ]);

        // Funcionário 4 - Inativo
        Funcionario::create([
            'matricula' => 'MG000004',
            'nome_completo' => 'Mariana Costa Fernandes',
            'funcao' => 'Coordenadora Administrativa',
            'status' => 'inativo',
            'cpf' => '321.654.987-00',
            'rg_numero' => '32.165.498-7',
            'rg_orgao_emissor' => 'SSP/RJ',
            'data_nascimento' => '1982-09-25',
            'nacionalidade' => 'Brasileira',
            'estado_civil' => 'casado',
            'endereco_logradouro' => 'Praça da República',
            'endereco_numero' => '50',
            'endereco_bairro' => 'Centro',
            'endereco_cep' => '25900-300',
            'endereco_municipio' => 'Magé',
            'endereco_uf' => 'RJ',
            'telefone_celular' => '(21) 96543-2109',
            'email' => 'mariana.costa@email.com',
            'grau_instrucao' => 'pos_graduacao',
            'nome_mae' => 'Regina Costa',
            'filiacao_uf' => 'RJ',
        ]);

        $this->command->info('✅ 4 funcionários de exemplo foram criados com sucesso!');
    }
}
