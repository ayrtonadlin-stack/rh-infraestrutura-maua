<?php

namespace App\Filament\Resources\FuncionarioResource\Pages;

use App\Filament\Resources\FuncionarioResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFuncionarios extends ListRecords
{
    protected static string $resource = FuncionarioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Novo Funcionário')
                ->icon('heroicon-o-plus'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // Aqui você pode adicionar widgets específicos desta página
        ];
    }
}
