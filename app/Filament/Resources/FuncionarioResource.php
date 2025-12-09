<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FuncionarioResource\Pages;
use App\Filament\Resources\FuncionarioResource\RelationManagers;
use App\Models\Funcionario;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Barryvdh\DomPDF\Facade\Pdf;

class FuncionarioResource extends Resource
{
    protected static ?string $model = Funcionario::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Funcionários';
    protected static ?string $modelLabel = 'Funcionário';
    protected static ?string $pluralModelLabel = 'Funcionários';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identificação')
                    ->schema([
                        Forms\Components\TextInput::make('matricula')
                            ->label('Matrícula')
                            ->default(fn () => Funcionario::gerarMatricula())
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20),
                        Forms\Components\TextInput::make('nome_completo')
                            ->label('Nome Completo')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('funcao')
                            ->label('Função/Cargo')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\Select::make('status')
                            ->options([
                                'pendente' => 'Pendente',
                                'ativo' => 'Ativo',
                                'inativo' => 'Inativo',
                                'rejeitado' => 'Rejeitado',
                            ])
                            ->default('pendente')
                            ->required(),
                        Forms\Components\TextInput::make('equipe')
                            ->label('Equipe')
                            ->maxLength(100),
                    ])->columns(2),

                Forms\Components\Section::make('Documentação Básica')
                    ->schema([
                        Forms\Components\TextInput::make('cpf')
                            ->label('CPF')
                            ->mask('999.999.999-99')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(14),
                        Forms\Components\TextInput::make('rg_numero')
                            ->label('RG - Número')
                            ->required()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('rg_orgao_emissor')
                            ->label('RG - Órgão Emissor')
                            ->required()
                            ->maxLength(20),
                        Forms\Components\DatePicker::make('rg_data_expedicao')
                            ->label('RG - Data de Expedição')
                            ->displayFormat('d/m/Y'),
                        Forms\Components\DatePicker::make('data_nascimento')
                            ->label('Data de Nascimento')
                            ->required()
                            ->displayFormat('d/m/Y')
                            ->native(false),
                        Forms\Components\TextInput::make('nacionalidade')
                            ->default('Brasileira')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\Select::make('estado_civil')
                            ->label('Estado Civil')
                            ->options([
                                'solteiro' => 'Solteiro(a)',
                                'casado' => 'Casado(a)',
                                'divorciado' => 'Divorciado(a)',
                                'viuvo' => 'Viúvo(a)',
                                'uniao_estavel' => 'União Estável',
                            ])
                            ->required(),
                    ])->columns(3),

                Forms\Components\Section::make('Endereço')
                    ->schema([
                        Forms\Components\TextInput::make('endereco_logradouro')
                            ->label('Logradouro')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('endereco_numero')
                            ->label('Número')
                            ->required()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('endereco_bairro')
                            ->label('Bairro')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('endereco_cep')
                            ->label('CEP')
                            ->mask('99999-999')
                            ->required()
                            ->maxLength(9),
                        Forms\Components\TextInput::make('endereco_municipio')
                            ->label('Município')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('endereco_uf')
                            ->label('UF')
                            ->maxLength(2)
                            ->required()
                            ->placeholder('RJ'),
                    ])->columns(3),

                Forms\Components\Section::make('Contato')
                    ->schema([
                        Forms\Components\TextInput::make('telefone_fixo')
                            ->label('Telefone Fixo')
                            ->tel()
                            ->mask('(99) 9999-9999')
                            ->maxLength(15),
                        Forms\Components\TextInput::make('telefone_celular')
                            ->label('Celular/WhatsApp')
                            ->tel()
                            ->mask('(99) 99999-9999')
                            ->required()
                            ->maxLength(15),
                        Forms\Components\TextInput::make('email')
                            ->label('E-mail')
                            ->email()
                            ->maxLength(255),
                    ])->columns(3),

                Forms\Components\Section::make('Documentação Legal')
                    ->schema([
                        Forms\Components\TextInput::make('pis_pasep')
                            ->label('PIS/PASEP')
                            ->maxLength(20),
                        Forms\Components\TextInput::make('ctps_numero')
                            ->label('CTPS - Número')
                            ->maxLength(20),
                        Forms\Components\TextInput::make('ctps_serie')
                            ->label('CTPS - Série')
                            ->maxLength(20),
                        Forms\Components\TextInput::make('titulo_eleitor')
                            ->label('Título de Eleitor')
                            ->maxLength(20),
                        Forms\Components\TextInput::make('titulo_zona')
                            ->label('Zona')
                            ->maxLength(10),
                        Forms\Components\TextInput::make('titulo_secao')
                            ->label('Seção')
                            ->maxLength(10),
                        Forms\Components\TextInput::make('cnh_numero')
                            ->label('CNH - Número')
                            ->maxLength(20),
                        Forms\Components\TextInput::make('cnh_categoria')
                            ->label('CNH - Categoria')
                            ->maxLength(5),
                        Forms\Components\TextInput::make('certificado_reservista')
                            ->label('Certificado de Reservista')
                            ->maxLength(20),
                    ])->columns(3),

                Forms\Components\Section::make('Dados Adicionais')
                    ->schema([
                        Forms\Components\Select::make('grau_instrucao')
                            ->label('Grau de Instrução')
                            ->options([
                                'fundamental_incompleto' => 'Fundamental Incompleto',
                                'fundamental_completo' => 'Fundamental Completo',
                                'medio_incompleto' => 'Médio Incompleto',
                                'medio_completo' => 'Médio Completo',
                                'superior_incompleto' => 'Superior Incompleto',
                                'superior_completo' => 'Superior Completo',
                                'pos_graduacao' => 'Pós-Graduação',
                            ]),
                        Forms\Components\TextInput::make('nome_pai')
                            ->label('Nome do Pai')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('nome_mae')
                            ->label('Nome da Mãe')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('filiacao_uf')
                            ->label('UF Filiação')
                            ->maxLength(2),
                    ])->columns(2),

                Forms\Components\Section::make('Uniforme')
                    ->schema([
                        Forms\Components\Select::make('uniforme_camisa')
                            ->label('Tamanho Camisa')
                            ->options([
                                'PP' => 'PP', 'P' => 'P', 'M' => 'M',
                                'G' => 'G', 'GG' => 'GG', 'XG' => 'XG', 'EXG' => 'EXG',
                            ]),
                        Forms\Components\Select::make('uniforme_calca')
                            ->label('Tamanho Calça')
                            ->options([
                                '36' => '36', '38' => '38', '40' => '40', '42' => '42',
                                '44' => '44', '46' => '46', '48' => '48', '50' => '50',
                                '52' => '52', '54' => '54',
                            ]),
                    ])->columns(2),

                Forms\Components\Section::make('Dados Bancários')
                    ->schema([
                        Forms\Components\TextInput::make('banco')
                            ->label('Banco')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('agencia')
                            ->label('Agência')
                            ->maxLength(20),
                        Forms\Components\TextInput::make('conta')
                            ->label('Conta')
                            ->maxLength(30),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('matricula')
                    ->label('Matrícula')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nome_completo')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('funcao')
                    ->label('Função')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cpf')
                    ->label('CPF')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pendente',
                        'success' => 'ativo',
                        'danger' => 'inativo',
                        'secondary' => 'rejeitado',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Cadastrado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pendente' => 'Pendente',
                        'ativo' => 'Ativo',
                        'inativo' => 'Inativo',
                        'rejeitado' => 'Rejeitado',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('ficha_cadastral')
                    ->label('Ficha Cadastral')
                    ->icon('heroicon-o-document-text')
                    ->color('success')
                    ->action(function (Funcionario $record) {
                        $pdf = Pdf::loadView('pdf.ficha-cadastral', ['funcionario' => $record])
                            ->setPaper('a4');

                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, "ficha_cadastral_{$record->matricula}.pdf");
                    }),
                Tables\Actions\Action::make('folha_ponto')
                    ->label('Folha de Ponto')
                    ->icon('heroicon-o-calendar')
                    ->color('info')
                    ->form([
                        Forms\Components\Select::make('mes')
                            ->label('Mês')
                            ->options([
                                1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
                                5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
                                9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
                            ])
                            ->default(date('n'))
                            ->required(),
                        Forms\Components\Select::make('ano')
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
                    ->action(function (array $data, Funcionario $record) {
                        $folha = \App\Models\FolhaPonto::where('funcionario_id', $record->id)
                            ->where('mes', $data['mes'])
                            ->where('ano', $data['ano'])
                            ->first();

                        if (!$folha) {
                            $folha = \App\Models\FolhaPonto::inicializarFolha($record->id, $data['mes'], $data['ano']);
                        }

                        $pdf = Pdf::loadView('pdf.folha-ponto', [
                            'funcionario' => $record,
                            'folha' => $folha,
                        ])->setPaper('a4', 'landscape');

                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, "folha_ponto_{$record->matricula}_{$data['mes']}_{$data['ano']}.pdf");
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\DependentesRelationManager::class,
            RelationManagers\DocumentosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFuncionarios::route('/'),
            'create' => Pages\CreateFuncionario::route('/create'),
            'edit' => Pages\EditFuncionario::route('/{record}/edit'),
        ];
    }
}
