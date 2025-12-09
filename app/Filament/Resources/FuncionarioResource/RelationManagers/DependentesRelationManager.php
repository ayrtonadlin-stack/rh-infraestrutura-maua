<?php

namespace App\Filament\Resources\FuncionarioResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class DependentesRelationManager extends RelationManager
{
    protected static string $relationship = 'dependentes';
    protected static ?string $title = 'Dependentes';
    protected static ?string $modelLabel = 'Dependente';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255)
                    ->label('Nome do Dependente'),
                Forms\Components\DatePicker::make('data_nascimento')
                    ->required()
                    ->label('Data de Nascimento')
                    ->displayFormat('d/m/Y')
                    ->native(false),
                Forms\Components\Select::make('tipo')
                    ->options([
                        'filho' => 'Filho',
                        'filha' => 'Filha',
                        'conjuge' => 'Cônjuge',
                        'outro' => 'Outro',
                    ])
                    ->default('filho')
                    ->required()
                    ->label('Tipo de Dependente'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->label('Nome'),
                Tables\Columns\TextColumn::make('data_nascimento')
                    ->label('Data de Nascimento')
                    ->date('d/m/Y'),
                Tables\Columns\TextColumn::make('idade')
                    ->label('Idade')
                    ->state(fn ($record) => $record->idade . ' anos'),
                Tables\Columns\TextColumn::make('tipo')
                    ->label('Tipo')
                    ->badge()
                    ->colors([
                        'primary' => 'filho',
                        'success' => 'filha',
                        'warning' => 'conjuge',
                        'secondary' => 'outro',
                    ]),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
