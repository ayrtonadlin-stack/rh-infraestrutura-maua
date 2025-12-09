<?php

namespace App\Filament\Resources\FuncionarioResource\Pages;

use App\Filament\Resources\FuncionarioResource;
use App\Models\FolhaPonto;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Barryvdh\DomPDF\Facade\Pdf;

class EditFuncionario extends EditRecord
{
    protected static string $resource = FuncionarioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Ação para imprimir Ficha Cadastral
            Actions\Action::make('ficha_cadastral')
                ->label('Imprimir Ficha Cadastral')
                ->icon('heroicon-o-document-text')
                ->color('success')
                ->action(function () {
                    $funcionario = $this->record;

                    $pdf = Pdf::loadView('pdf.ficha-cadastral', [
                        'funcionario' => $funcionario,
                    ])->setPaper('a4');

                    return response()->streamDownload(function () use ($pdf) {
                        echo $pdf->output();
                    }, "ficha_cadastral_{$funcionario->matricula}.pdf");
                }),

            // Ação para gerenciar Folha de Ponto
            Actions\Action::make('folha_ponto')
                ->label('Gerenciar Folha de Ponto')
                ->icon('heroicon-o-calendar')
                ->color('info')
                ->form([
                    \Filament\Forms\Components\Select::make('mes')
                        ->label('Mês')
                        ->options([
                            1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
                            5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
                            9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
                        ])
                        ->default(date('n'))
                        ->required(),
                    \Filament\Forms\Components\Select::make('ano')
                        ->label('Ano')
                        ->options(function () {
                            $years = [];
                            $currentYear = date('Y');
                            for ($i = $currentYear - 1; $i <= $currentYear + 1; $i++) {
                                $years[$i] = $i;
                            }
                            return $years;
                        })
                        ->default(date('Y'))
                        ->required(),
                ])
                ->action(function (array $data) {
                    $funcionario = $this->record;

                    // Verificar se já existe
                    $folha = FolhaPonto::where('funcionario_id', $funcionario->id)
                        ->where('mes', $data['mes'])
                        ->where('ano', $data['ano'])
                        ->first();

                    if (!$folha) {
                        $folha = FolhaPonto::inicializarFolha($funcionario->id, $data['mes'], $data['ano']);

                        Notification::make()
                            ->success()
                            ->title('Folha de ponto criada')
                            ->body("Folha de ponto de {$folha->mes_nome}/{$folha->ano} criada com sucesso.")
                            ->send();
                    }

                    // Gerar PDF
                    $pdf = Pdf::loadView('pdf.folha-ponto', [
                        'funcionario' => $funcionario,
                        'folha' => $folha,
                    ])->setPaper('a4', 'landscape');

                    return response()->streamDownload(function () use ($pdf) {
                        echo $pdf->output();
                    }, "folha_ponto_{$funcionario->matricula}_{$data['mes']}_{$data['ano']}.pdf");
                }),

            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Funcionário atualizado')
            ->body('Os dados do funcionário foram atualizados com sucesso.');
    }
}
