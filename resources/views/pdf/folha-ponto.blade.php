<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Folha de Ponto - {{ $funcionario->nome_completo }}</title>
    <style>
        @page {
            /* Margens reduzidas para maximizar o espaço útil */
            margin: 10mm 8mm;
            size: A4 portrait;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 8.5pt; /* Fonte ligeiramente reduzida */
            line-height: 1.1; /* Espaçamento de linha reduzido */
            color: #000;
        }
        .header {
            border: 2px solid #000;
            padding: 5px; /* Padding reduzido */
            margin-bottom: 10px; /* Margem reduzida */
        }
        .header-top {
            display: table;
            width: 100%;
            border-bottom: 1px solid #666;
            padding-bottom: 5px; /* Padding reduzido */
            margin-bottom: 5px; /* Margem reduzida */
        }
        .logo {
            display: table-cell;
            width: 25%;
            vertical-align: middle;
            font-weight: bold;
            font-size: 12pt; /* Fonte reduzida */
        }
        .header-title {
            display: table-cell;
            width: 75%;
            text-align: right;
            vertical-align: middle;
        }
        .header-title h3 {
            margin: 0;
            font-size: 8pt; /* Fonte reduzida */
            font-weight: normal;
        }
        .info-section {
            margin-bottom: 5px; /* Margem reduzida */
        }
        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 2px; /* Margem reduzida */
        }
        .info-label {
            display: table-cell;
            width: 20%;
            font-weight: bold;
            font-size: 7.5pt; /* Fonte reduzida */
        }
        .info-value {
            display: table-cell;
            width: 30%;
            border-bottom: 1px solid #000;
            font-size: 8.5pt; /* Fonte reduzida */
        }
        .section-title {
            background-color: #e0e0e0;
            padding: 3px 8px; /* Padding reduzido */
            font-weight: bold;
            font-size: 8pt;
            text-align: center;
            margin: 5px 0 3px 0; /* Margem reduzida */
            border: 1px solid #999;
        }
        .ponto-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 3px; /* Margem reduzida */
        }
        .ponto-table th {
            background-color: #d0d0d0;
            border: 1px solid #000;
            padding: 3px 1px; /* Padding reduzido */
            text-align: center;
            font-size: 6.5pt; /* Fonte reduzida */
            font-weight: bold;
        }
        .ponto-table td {
            border: 1px solid #666;
            padding: 2px 1px; /* Padding reduzido */
            text-align: center;
            height: 18px; /* Altura da linha reduzida */
            font-size: 7pt;
        }
        .ponto-table .dia-col {
            width: 4%;
            font-weight: bold;
            background-color: #f5f5f5;
        }
        .ponto-table .entrada-col,
        .ponto-table .assinatura-col,
        .ponto-table .saida-col {
            width: 12%;
        }
        .fim-semana {
            background-color: #e8e8e8;
            font-weight: bold;
            font-size: 7pt;
        }
        .footer {
            /* Garante que o rodapé fique sempre na última página e bem ajustado */
            position: absolute;
            bottom: 10mm;
            width: 100%;
            left: 0;
            padding-left: 8mm; /* Ajusta o padding conforme a margem da página */
            padding-right: 8mm; /* Ajusta o padding conforme a margem da página */
            box-sizing: border-box;
            border-top: none; /* A borda será colocada nas linhas de assinatura */
            margin-top: 5px;
        }
        .signature-line {
            display: flex;
            align-items: flex-end;
            margin-bottom: 8px; /* Espaço entre as linhas de assinatura */
            font-size: 8pt;
        }
        .signature-line span:first-child {
            white-space: nowrap;
            font-weight: bold;
        }
        .signature-line span:last-child {
            flex-grow: 1;
            border-bottom: 1px solid #000;
            margin-left: 5px;
            height: 15px; /* Para garantir o espaço vertical antes da linha */
        }

        /* Ajuste para caber tudo em uma página, forçando o corpo a ser o mais compacto possível */
        @media print {
            .footer {
                position: static; /* Volta para o fluxo normal de impressão */
                margin-top: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-top">
            <div class="logo">MAGÉ</div>
            <div class="header-title">
                <h3>SECRETARIA MUNICIPAL DE INFRAESTRUTURA</h3>
                <h3>RUA PAULO TEIXEIRA DOS SANTOS, N.º 75, CEP 25935-082</h3>
                <h3>FOLHA DE PONTO</h3>
            </div>
        </div>

        <div class="info-section">
            <div class="info-row">
                <span class="info-label">NOME:</span>
                <span class="info-value" style="width: 80%;">{{ $funcionario->nome_completo }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">FUNÇÃO:</span>
                <span class="info-value">{{ $funcionario->funcao }}</span>
                <span class="info-label" style="width: 15%; text-align: right;">MATRÍCULA:</span>
                <span class="info-value" style="width: 15%;">{{ $funcionario->matricula }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">EQUIPE:</span>
                <span class="info-value">{{ $funcionario->equipe ?? '-' }}</span>
                <span class="info-label" style="width: 15%; text-align: right;">MÊS:</span>
                <span class="info-value" style="width: 15%;">{{ strtoupper($folha->mes_nome) }}</span>
                <span class="info-label" style="width: 10%; text-align: right;">ANO:</span>
                <span class="info-value" style="width: 10%;">{{ $folha->ano }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">ENCARREGADO:</span>
                <span class="info-value" style="width: 80%;">{{ $funcionario->encarregado ?? '-' }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">HORÁRIO:</span>
                <span class="info-value" style="width: 80%;"></span>
            </div>

            <div style="margin-top: 3px;">
                <span style="font-size: 7.5pt; font-weight: bold;">DISTRITO DE LOTAÇÃO: 5º DISTRITO</span>
            </div>

            <div style="margin-top: 3px;">
                <span style="font-size: 7.5pt; font-weight: bold;">DIRETOR: HELIO SANDRO VICENTE DA SILVA</span>
            </div>
        </div>
    </div>

    <div class="section-title">REFEIÇÃO/DESCANSO</div>

    <table class="ponto-table">
        <thead>
            <tr>
                <th>Dia</th>
                <th>Entrada</th>
                <th>Assinatura</th>
                <th>Saída</th>
                <th>Entrada</th>
                <th>Assinatura</th>
                <th>Saída</th>
            </tr>
        </thead>
        <tbody>
            @php
                $registros = $folha->registros;
                // Ajusta o loop para o número real de dias no mês
                $diasNoMes = \Carbon\Carbon::createFromDate($folha->ano, $folha->mes, 1)->daysInMonth;
            @endphp

            @for($dia = 1; $dia <= $diasNoMes; $dia++)
                @php
                    $registro = $registros[$dia] ?? null;
                    $data = \Carbon\Carbon::createFromDate($folha->ano, $folha->mes, $dia);
                    $diaSemana = $data->dayOfWeek;
                    $isFimSemana = ($diaSemana == 0 || $diaSemana == 6); // Domingo (0) ou Sábado (6)
                @endphp

                <tr>
                    <td class="dia-col">{{ $dia }}</td>

                    @if($isFimSemana)
                        @php
                            $nomeDia = $diaSemana == 0 ? 'DOMINGO' : 'SÁBADO';
                        @endphp
                        {{-- Ocupa 3 colunas para a primeira parte do dia --}}
                        <td colspan="3" class="fim-semana">{{ $nomeDia }}</td>
                        {{-- Ocupa 3 colunas para a segunda parte do dia --}}
                        <td colspan="3" class="fim-semana">{{ $nomeDia }}</td>
                    @else
                        {{-- Mantém as 6 colunas de registro em branco --}}
                        <td class="entrada-col"></td>
                        <td class="assinatura-col"></td>
                        <td class="saida-col"></td>
                        <td class="entrada-col"></td>
                        <td class="assinatura-col"></td>
                        <td class="saida-col"></td>
                    @endif
                </tr>
            @endfor
        </tbody>
    </table>

    <div class="footer">
        <div class="signature-line">
            <span>Ass. do Servidor:________________________________________________________________________________________________</span>
            <span></span>
        </div>

        <div class="signature-line">
            <span>Responsável pelo ponto:__________________________________________________________________________________________</span>
            <span></span>
        </div>

        <div class="signature-line">
            <span>OBS:____________________________________________________________________________________________________________</span>
            <span></span>
        </div>
    </div>
</body>
</html>
