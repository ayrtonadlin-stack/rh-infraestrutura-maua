<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PreCadastroController extends Controller
{
    public function index()
    {
        return view('pre-cadastro.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome_completo' => 'required|string|max:255',
            'cpf' => 'required|string|size:14|unique:funcionarios,cpf',
            'data_nascimento' => 'required|date|before:today',
            'telefone_celular' => 'required|string|max:15',
            'email' => 'nullable|email|max:255',
            'endereco_logradouro' => 'required|string|max:255',
            'endereco_numero' => 'required|string|max:20',
            'endereco_bairro' => 'required|string|max:100',
            'endereco_cep' => 'required|string|size:9',
            'endereco_municipio' => 'required|string|max:100',
            'endereco_uf' => 'required|string|size:2',
            'rg_numero' => 'required|string|max:20',
            'rg_orgao_emissor' => 'required|string|max:20',
            'funcao' => 'required|string|max:100',
            'estado_civil' => 'nullable|in:solteiro,casado,divorciado,viuvo,uniao_estavel',
            'foto' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'documento_rg' => 'required|mimes:pdf,jpeg,jpg,png|max:2048',
            'documento_cpf' => 'required|mimes:pdf,jpeg,jpg,png|max:2048',
        ], [
            'cpf.unique' => 'Este CPF já está cadastrado no sistema.',
            'foto.required' => 'A foto 3x4 é obrigatória.',
            'documento_rg.required' => 'O documento RG é obrigatório.',
            'documento_cpf.required' => 'O documento CPF é obrigatório.',
        ]);

        try {
            // Criar funcionário
            $funcionario = Funcionario::create([
                'matricula' => Funcionario::gerarMatricula(),
                'nome_completo' => $request->nome_completo,
                'cpf' => $request->cpf,
                'data_nascimento' => $request->data_nascimento,
                'telefone_celular' => $request->telefone_celular,
                'email' => $request->email,
                'endereco_logradouro' => $request->endereco_logradouro,
                'endereco_numero' => $request->endereco_numero,
                'endereco_bairro' => $request->endereco_bairro,
                'endereco_cep' => $request->endereco_cep,
                'endereco_municipio' => $request->endereco_municipio,
                'endereco_uf' => $request->endereco_uf,
                'rg_numero' => $request->rg_numero,
                'rg_orgao_emissor' => $request->rg_orgao_emissor,
                'funcao' => $request->funcao,
                'nacionalidade' => 'Brasileira',
                'estado_civil' => $request->estado_civil ?? 'solteiro',
                'status' => 'pendente',
            ]);

            // Upload de documentos
            $documentos = [
                'foto' => 'fotos_3x4',
                'documento_rg' => 'rg',
                'documento_cpf' => 'cpf',
            ];

            foreach ($documentos as $campo => $tipo) {
                if ($request->hasFile($campo)) {
                    $file = $request->file($campo);
                    $path = $file->store('documentos', 'public');

                    Documento::create([
                        'funcionario_id' => $funcionario->id,
                        'tipo' => $tipo,
                        'arquivo_nome' => $file->getClientOriginalName(),
                        'arquivo_path' => $path,
                        'arquivo_mime' => $file->getMimeType(),
                        'arquivo_tamanho' => $file->getSize(),
                    ]);
                }
            }

            return redirect()->route('pre-cadastro.sucesso')->with('matricula', $funcionario->matricula);

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao realizar pré-cadastro: ' . $e->getMessage())->withInput();
        }
    }

    public function sucesso()
    {
        if (!session('matricula')) {
            return redirect()->route('pre-cadastro.index');
        }

        return view('pre-cadastro.sucesso');
    }
}
