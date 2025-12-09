<?php

namespace App\Filament\Resources\FuncionarioResource\Pages;

use App\Filament\Resources\FuncionarioResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateFuncionario extends CreateRecord
{
    protected static string $resource = FuncionarioResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Funcionário cadastrado')
            ->body('O funcionário foi cadastrado com sucesso no sistema.');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Garantir que a matrícula seja gerada se não fornecida
        if (empty($data['matricula'])) {
            $data['matricula'] = \App\Models\Funcionario::gerarMatricula();
        }

        return $data;
    }
}
