<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class FolhaPonto extends Model
{
    use HasFactory;

    protected $table = 'folha_ponto';

    protected $fillable = [
        'funcionario_id',
        'mes',
        'ano',
        'registros',
        'fechada',
    ];

    protected $casts = [
        'registros' => 'array',
        'fechada' => 'boolean',
    ];

    public function funcionario(): BelongsTo
    {
        return $this->belongsTo(Funcionario::class);
    }

    public function getMesNomeAttribute(): string
    {
        $meses = [
            1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
            5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
            9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
        ];
        return $meses[$this->mes];
    }

    public function getPeriodoAttribute(): string
    {
        return $this->mes_nome . '/' . $this->ano;
    }

    // Inicializar folha de ponto com estrutura padrão
    public static function inicializarFolha(int $funcionarioId, int $mes, int $ano): self
    {
        $registros = [];
        $diasNoMes = Carbon::createFromDate($ano, $mes, 1)->daysInMonth;

        for ($dia = 1; $dia <= 31; $dia++) {
            if ($dia > $diasNoMes) {
                $registros[$dia] = null;
                continue;
            }

            $data = Carbon::createFromDate($ano, $mes, $dia);
            $diaSemana = $data->dayOfWeek;

            if ($diaSemana == Carbon::SATURDAY || $diaSemana == Carbon::SUNDAY) {
                $registros[$dia] = [
                    'tipo' => 'fim_semana',
                    'entrada' => null,
                    'saida_refeicao' => null,
                    'retorno_refeicao' => null,
                    'saida' => null,
                ];
            } else {
                $registros[$dia] = [
                    'tipo' => 'normal',
                    'entrada' => null,
                    'saida_refeicao' => null,
                    'retorno_refeicao' => null,
                    'saida' => null,
                ];
            }
        }

        return self::create([
            'funcionario_id' => $funcionarioId,
            'mes' => $mes,
            'ano' => $ano,
            'registros' => $registros,
            'fechada' => false,
        ]);
    }

    // Atualizar registro de um dia específico
    public function atualizarDia(int $dia, array $dados): void
    {
        $registros = $this->registros;
        $registros[$dia] = array_merge($registros[$dia] ?? [], $dados);
        $this->registros = $registros;
        $this->save();
    }
}
