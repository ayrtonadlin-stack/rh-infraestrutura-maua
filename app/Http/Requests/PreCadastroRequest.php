<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PreCadastroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Acesso público
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Dados Pessoais
            'nome_completo' => 'required|string|max:255',
            'cpf' => 'required|string|size:14|unique:funcionarios,cpf',
            'data_nascimento' => 'required|date|before:today',
            'rg_numero' => 'required|string|max:20',
            'rg_orgao_emissor' => 'required|string|max:20',
            'funcao' => 'required|string|max:100',
            'estado_civil' => 'nullable|in:solteiro,casado,divorciado,viuvo,uniao_estavel',

            // Contato
            'telefone_celular' => 'required|string|max:15',
            'email' => 'nullable|email|max:255',

            // Endereço
            'endereco_cep' => 'required|string|size:9',
            'endereco_logradouro' => 'required|string|max:255',
            'endereco_numero' => 'required|string|max:20',
            'endereco_bairro' => 'required|string|max:100',
            'endereco_municipio' => 'required|string|max:100',
            'endereco_uf' => 'required|string|size:2',

            // Documentos
            'foto' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'documento_rg' => 'required|mimes:pdf,jpeg,jpg,png|max:2048',
            'documento_cpf' => 'required|mimes:pdf,jpeg,jpg,png|max:2048',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nome_completo.required' => 'O nome completo é obrigatório.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.unique' => 'Este CPF já está cadastrado no sistema.',
            'cpf.size' => 'O CPF deve ter 14 caracteres (com pontos e hífen).',
            'data_nascimento.required' => 'A data de nascimento é obrigatória.',
            'data_nascimento.before' => 'A data de nascimento deve ser anterior a hoje.',
            'telefone_celular.required' => 'O telefone celular é obrigatório.',
            'email.email' => 'O e-mail informado não é válido.',
            'endereco_cep.required' => 'O CEP é obrigatório.',
            'endereco_cep.size' => 'O CEP deve ter 9 caracteres (com hífen).',
            'foto.required' => 'A foto 3x4 é obrigatória.',
            'foto.image' => 'O arquivo deve ser uma imagem.',
            'foto.max' => 'A foto não pode ter mais de 2MB.',
            'documento_rg.required' => 'O documento RG é obrigatório.',
            'documento_rg.max' => 'O documento RG não pode ter mais de 2MB.',
            'documento_cpf.required' => 'O documento CPF é obrigatório.',
            'documento_cpf.max' => 'O documento CPF não pode ter mais de 2MB.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'nome_completo' => 'nome completo',
            'data_nascimento' => 'data de nascimento',
            'telefone_celular' => 'telefone celular',
            'endereco_cep' => 'CEP',
            'endereco_logradouro' => 'logradouro',
            'endereco_numero' => 'número',
            'endereco_bairro' => 'bairro',
            'endereco_municipio' => 'município',
            'endereco_uf' => 'UF',
        ];
    }
}
