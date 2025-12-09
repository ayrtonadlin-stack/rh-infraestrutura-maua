<?php

namespace App\Filament\Resources\FuncionarioResource\RelationManagers;

use App\Models\Documento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class DocumentosRelationManager extends RelationManager
{
    protected static string $relationship = 'documentos';
    protected static ?string $title = 'Documentos';
    protected static ?string $modelLabel = 'Documento';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tipo')
                    ->label('Tipo de Documento')
                    ->options(Documento::getTiposDisponiveis())
                    ->required()
                    ->searchable(),
                Forms\Components\FileUpload::make('arquivo_path')
                    ->label('Arquivo')
                    ->directory('documentos')
                    ->preserveFilenames()
                    ->maxSize(5120) // 5MB
                    ->acceptedFileTypes(['application/pdf', 'image/*'])
                    ->required()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $set('arquivo_nome', $state->getClientOriginalName());
                            $set('arquivo_mime', $state->getMimeType());
                            $set('arquivo_tamanho', $state->getSize());
                        }
                    }),
                Forms\Components\Hidden::make('arquivo_nome'),
                Forms\Components\Hidden::make('arquivo_mime'),
                Forms\Components\Hidden::make('arquivo_tamanho'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tipo')
                    ->label('Tipo')
                    ->formatStateUsing(fn (string $state) => Documento::getTiposDisponiveis()[$state] ?? $state),
                Tables\Columns\TextColumn::make('arquivo_nome')
                    ->label('Arquivo')
                    ->limit(30),
                Tables\Columns\TextColumn::make('tamanho_formatado')
                    ->label('Tamanho'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Enviado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($record) {
                        return Storage::download($record->arquivo_path, $record->arquivo_nome);
                    }),
                Tables\Actions\Action::make('visualizar')
                    ->label('Visualizar')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record) => Storage::url($record->arquivo_path))
                    ->openUrlInNewTab(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
