<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Ficha Cadastral - {{ $funcionario->nome_completo }}</title>
    <style>
        @page {
            margin: 20mm 15mm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            color: #000;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 16pt;
            margin: 0 0 5px 0;
            font-weight: bold;
        }
        .header h2 {
            font-size: 12pt;
            margin: 0;
            font-weight: normal;
        }
        .section {
            margin-bottom: 15px;
        }
        .section-title {
            background-color: #e0e0e0;
            padding: 5px 10px;
            font-weight: bold;
            font-size: 11pt;
            margin-bottom: 10px;
            border-left: 4px solid #333;
        }
        .row {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }
        .col {
            display: table-cell;
            padding: 3px 5px;
            border: 1px solid #ccc;
            vertical-align: top;
        }
        .col-label {
            font-weight: bold;
            background-color: #f5f5f5;
            width: 30%;
        }
        .col-value {
            width: 70%;
        }
        .col-2 {
            width: 50%;
        }
        .col-3 {
            width: 33.33%;
        }
        .table-dependentes {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table-dependentes th {
            background-color: #f0f0f0;
            padding: 6px;
            border: 1px solid #999;
            text-align: left;
            font-weight: bold;
        }
        .table-dependentes td {
            padding: 6px;
            border: 1px solid #ccc;
        }
        .footer {
            margin-top: 40px;
            border-top: 1px solid #ccc;
            padding-top: 20px;
        }
        .signature {
            display: inline-block;
            width: 45%;
            text-align: center;
            margin-top: 50px;
        }
        .signature-line {
            border-top: 1px solid #000;
            padding-top: 5px;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <!-- Cabeçalho -->
    <div class="header">
        <h1>FICHA CADASTRAL DE FUNCIONÁRIO</h1>
        <h2>5º Distrito de Infraestrutura de Magé</h2>
    </div>

    <!-- Identificação -->
    <div class="section">
        <div class="section-title">IDENTIFICAÇÃO</div>
        
        <div class="row">
            <div class="col col-label">Nome Completo:</div>
            <div class="col col-value">{{ $funcionario->nome_completo }}</div>
        </div>

        <div class="row">
            <div class="col col-label col-2">Matrícula:</div>
            <div class="col col-value col-2">{{ $funcionario->matricula }}</div>
            <div class="col col-label col-2">Função/Cargo:</div>
            <div class="col col-value col-2">{{ $funcionario->funcao }}</div>
        </div>

        <div class="row">
            <div class="col col-label col-3">CPF:</div>
            <div class="col col-value col-3">{{ $funcionario->cpf_formatado }}</div>
            <div class="col col-label col-3">Data de Nascimento:</div>
            <div class="col col-value col-3">{{ $funcionario->data_nascimento->format('d/m/Y') }}</div>
            <div class="col col-label col-3">Nacionalidade:</div>
            <div class="col col-value col-3">{{ $funcionario->nacionalidade }}</div>
        </div>

        <div class="row">
            <div class="col col-label col-3">RG:</div>
            <div class="col col-value col-3">{{ $funcionario->rg_numero }}</div>
            <div class="col col-label col-3">Órgão Emissor:</div>
            <div class="col col-value col-3">{{ $funcionario->rg_orgao_emissor }}</div>
            <div class="col col-label col-3">Data Expedição:</div>
            <div class="col col-value col-3">{{ $funcionario->rg_data_expedicao?->format('d/m/Y') ?? '-' }}</div>
        </div>

        <div class="row">
            <div class="col col-label col-2">Estado Civil:</div>
            <div class="col col-value col-2">{{ ucfirst(str_replace('_', ' ', $funcionario->estado_civil)) }}</div>
            <div class="col col-label col-2">Equipe:</div>
            <div class="col col-value col-2">{{ $funcionario->equipe ?? '-' }}</div>
        </div>
    </div>

    <!-- Endereço -->
    <div class="section">
        <div class="section-title">ENDEREÇO</div>
        
        <div class="row">
            <div class="col col-label">Endereço Completo:</div>
            <div class="col col-value">{{ $funcionario->endereco_completo }}</div>
        </div>
    </div>

    <!-- Contato -->
    <div class="section">
        <div class="section-title">CONTATO</div>
        
        <div class="row">
            <div class="col col-label col-3">Telefone Fixo:</div>
            <div class="col col-value col-3">{{ $funcionario->telefone_fixo ?? '-' }}</div>
            <div class="col col-label col-3">Celular/WhatsApp:</div>
            <div class="col col-value col-3">{{ $funcionario->telefone_celular }}</div>
            <div class="col col-label col-3">E-mail:</div>
            <div class="col col-value col-3">{{ $funcionario->email ?? '-' }}</div>
        </div>
    </div>

    <!-- Documentação Legal -->
    <div class="section">
        <div class="section-title">DOCUMENTAÇÃO LEGAL</div>
        
        <div class="row">
            <div class="col col-label col-2">PIS/PASEP:</div>
            <div class="col col-value col-2">{{ $funcionario->pis_pasep ?? '-' }}</div>
            <div class="col col-label col-2">CTPS:</div>
            <div class="col col-value col-2">{{ $funcionario->ctps_numero ?? '-' }} / {{ $funcionario->ctps_serie ?? '-' }}</div>
        </div>

        <div class="row">
            <div class="col col-label col-3">Título de Eleitor:</div>
            <div class="col col-value col-3">{{ $funcionario->titulo_eleitor ?? '-' }}</div>
            <div class="col col-label col-3">Zona:</div>
            <div class="col col-value col-3">{{ $funcionario->titulo_zona ?? '-' }}</div>
            <div class="col col-label col-3">Seção:</div>
            <div class="col col-value col-3">{{ $funcionario->titulo_secao ?? '-' }}</div>
        </div>

        <div class="row">
            <div class="col col-label col-2">CNH:</div>
            <div class="col col-value col-2">{{ $funcionario->cnh_numero ?? '-' }}</div>
            <div class="col col-label col-2">Categoria:</div>
            <div class="col col-value col-2">{{ $funcionario->cnh_categoria ?? '-' }}</div>
        </div>

        <div class="row">
            <div class="col col-label col-2">Certificado de Reservista:</div>
            <div class="col col-value col-2">{{ $funcionario->certificado_reservista ?? '-' }}</div>
            <div class="col col-label col-2">Grau de Instrução:</div>
            <div class="col col-value col-2">{{ $funcionario->grau_instrucao ? ucfirst(str_replace('_', ' ', $funcionario->grau_instrucao)) : '-' }}</div>
        </div>
    </div>

    <!-- Filiação -->
    <div class="section">
        <div class="section-title">FILIAÇÃO</div>
        
        <div class="row">
            <div class="col col-label col-2">Nome do Pai:</div>
            <div class="col col-value col-2">{{ $funcionario->nome_pai ?? '-' }}</div>
            <div class="col col-label col-2">UF:</div>
            <div class="col col-value col-2">{{ $funcionario->filiacao_uf ?? '-' }}</div>
        </div>

        <div class="row">
            <div class="col col-label col-2">Nome da Mãe:</div>
            <div class="col col-value col-2">{{ $funcionario->nome_mae ?? '-' }}</div>
            <div class="col col-label col-2">UF:</div>
            <div class="col col-value col-2">{{ $funcionario->filiacao_uf ?? '-' }}</div>
        </div>
    </div>

    <!-- Uniforme -->
    <div class="section">
        <div class="section-title">UNIFORME</div>
        
        <div class="row">
            <div class="col col-label col-2">Tamanho Camisa:</div>
            <div class="col col-value col-2">{{ $funcionario->uniforme_camisa ?? '-' }}</div>
            <div class="col col-label col-2">Tamanho Calça:</div>
            <div class="col col-value col-2">{{ $funcionario->uniforme_calca ?? '-' }}</div>
        </div>
    </div>

    <!-- Dados Bancários -->
    <div class="section">
        <div class="section-title">DADOS BANCÁRIOS</div>
        
        <div class="row">
            <div class="col col-label col-3">Banco:</div>
            <div class="col col-value col-3">{{ $funcionario->banco ?? '-' }}</div>
            <div class="col col-label col-3">Agência:</div>
            <div class="col col-value col-3">{{ $funcionario->agencia ?? '-' }}</div>
            <div class="col col-label col-3">Conta:</div>
            <div class="col col-value col-3">{{ $funcionario->conta ?? '-' }}</div>
        </div>
    </div>

    <!-- Dependentes -->
    @if($funcionario->dependentes->count() > 0)
    <div class="section">
        <div class="section-title">DEPENDENTES</div>
        
        <table class="table-dependentes">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Data de Nascimento</th>
                    <th>Idade</th>
                    <th>Tipo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($funcionario->dependentes as $dependente)
                <tr>
                    <td>{{ $dependente->nome }}</td>
                    <td>{{ $dependente->data_nascimento->format('d/m/Y') }}</td>
                    <td>{{ $dependente->idade }} anos</td>
                    <td>{{ ucfirst($dependente->tipo) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Assinaturas -->
    <div class="footer">
        <div class="signature" style="float: left;">
            <div class="signature-line">
                {{ $funcionario->nome_completo }}<br>
                <small>Assinatura do Funcionário</small>
            </div>
        </div>

        <div class="signature" style="float: right;">
            <div class="signature-line">
                Recursos Humanos<br>
                <small>5º Distrito de Infraestrutura</small>
            </div>
        </div>
        <div style="clear: both;"></div>
        
        <p style="text-align: center; margin-top: 30px; font-size: 9pt; color: #666;">
            Documento emitido em {{ date('d/m/Y H:i') }}
        </p>
    </div>
</body>
</html>