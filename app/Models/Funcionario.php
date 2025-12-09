<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Funcionario extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'funcionarios';

    protected $fillable = [
        'matricula',
        'nome_completo',
        'funcao',
        'status',
        'cpf',
        'rg_numero',
        'rg_orgao_emissor',
        'rg_data_expedicao',
        'data_nascimento',
        'nacionalidade',
        'estado_civil',
        'endereco_logradouro',
        'endereco_numero',
        'endereco_bairro',
        'endereco_cep',
        'endereco_municipio',
        'endereco_uf',
        'telefone_fixo',
        'telefone_celular',
        'email',
        'pis_pasep',
        'ctps_numero',
        'ctps_serie',
        'titulo_eleitor',
        'titulo_zona',
        'titulo_secao',
        'cnh_numero',
        'cnh_categoria',
        'certificado_reservista',
        'grau_instrucao',
        'nome_pai',
        'nome_mae',
        'filiacao_uf',
        'uniforme_camisa',
        'uniforme_calca',
        'banco',
        'agencia',
        'conta',
        'equipe',
        'distrito',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'rg_data_expedicao' => 'date',
    ];

    public function dependentes(): HasMany
    {
        return $this->hasMany(Dependente::class);
    }

    public function documentos(): HasMany
    {
        return $this->hasMany(Documento::class);
    }

    public function folhasPonto(): HasMany
    {
        return $this->hasMany(FolhaPonto::class);
    }

    // Accessor para formatar CPF
    public function getCpfFormatadoAttribute(): string
    {
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $this->cpf);
    }

    // Accessor para endereço completo
    public function getEnderecoCompletoAttribute(): string
    {
        return "{$this->endereco_logradouro}, {$this->endereco_numero} - {$this->endereco_bairro}, {$this->endereco_municipio}/{$this->endereco_uf} - CEP: {$this->endereco_cep}";
    }

    // Scope para funcionários ativos
    public function scopeAtivos($query)
    {
        return $query->where('status', 'ativo');
    }

    // Scope para pré-cadastros pendentes
    public function scopePendentes($query)
    {
        return $query->where('status', 'pendente');
    }

    // Gerar matrícula automática
    public static function gerarMatricula(): string
    {
        $ultimo = self::withTrashed()->orderBy('id', 'desc')->first();
        $numero = $ultimo ? intval(substr($ultimo->matricula, 2)) + 1 : 1;
        return 'MG' . str_pad($numero, 6, '0', STR_PAD_LEFT);
    }
}
