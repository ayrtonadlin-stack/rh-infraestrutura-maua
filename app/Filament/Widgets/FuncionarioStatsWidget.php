<?php

namespace App\Filament\Widgets;

use App\Models\Funcionario;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FuncionarioStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalFuncionarios = Funcionario::count();
        $ativos = Funcionario::where('status', 'ativo')->count();
        $pendentes = Funcionario::where('status', 'pendente')->count();
        $inativos = Funcionario::where('status', 'inativo')->count();

        return [
            Stat::make('Total de Funcionários', $totalFuncionarios)
                ->description('Cadastrados no sistema')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary')
                ->chart([7, 12, 15, 18, 22, 25, $totalFuncionarios]),

            Stat::make('Funcionários Ativos', $ativos)
                ->description('Com status ativo')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->chart([5, 8, 12, 15, 18, 20, $ativos]),

            Stat::make('Pré-Cadastros Pendentes', $pendentes)
                ->description('Aguardando validação')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning')
                ->url(route('filament.admin.resources.funcionarios.index', ['tableFilters[status][value]' => 'pendente']))
                ->chart([2, 3, 5, 4, 6, 5, $pendentes]),

            Stat::make('Funcionários Inativos', $inativos)
                ->description('Desligados ou afastados')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger')
                ->chart([0, 1, 1, 2, 2, 3, $inativos]),
        ];
    }
}