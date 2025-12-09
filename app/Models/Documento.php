<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Documento extends Model
{
    use HasFactory;

    protected $table = 'documentos';

    protected $fillable = [
        'funcionario_id',
        'tipo',
        'arquivo_nome',
        'arquivo_path',
        'arquivo_mime',
        'arquivo_tamanho',
    ];

    public function funcionario(): BelongsTo
    {
        return $this->belongsTo(Funcionario::class);
    }

    public function getUrlAttribute(): string
    {
        return Storage::url($this->arquivo_path);
    }

    public function getTamanhoFormatadoAttribute(): string
    {
        $bytes = $this->arquivo_tamanho;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' bytes';
    }

    public static function getTiposDisponiveis(): array
    {
        return [
            'fotos_3x4' => '03 FOTOS 3X4 (Recente)',
            'rg' => 'Carteira de Identidade (RG)',
            'cpf' => 'CPF',
            'pis_pasep' => 'PIS/PASEP',
            'ctps' => 'Carteira de Trabalho (CTPS)',
            'certidao_casamento_nascimento' => 'Certidão de Casamento ou Nascimento',
            'certidao_nascimento_dependentes' => 'Certidão de Nascimento dos Dependentes',
            'comprovante_residencia' => 'Comprovante de Residência',
            'declaracao_escolaridade' => 'Declaração de Escolaridade',
            'certificado_reservista' => 'Certificado de Reservista',
            'titulo_eleitor' => 'Título Eleitoral',
            'certidao_quitacao_eleitoral' => 'Certidão de Quitação Eleitoral',
            'comprovante_dados_bancarios' => 'Comprovante de Dados Bancários',
            'antecedentes_estadual' => 'Antecedentes Criminais (Justiça Estadual)',
            'antecedentes_federal' => 'Antecedentes Criminais (Justiça Federal)',
        ];
    }
}
