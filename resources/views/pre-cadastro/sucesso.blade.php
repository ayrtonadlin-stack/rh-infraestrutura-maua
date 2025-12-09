<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pré-Cadastro Enviado - RH 5º Distrito</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div class="bg-white shadow-lg rounded-lg p-8 text-center">
                <!-- Ícone de Sucesso -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-6">
                    <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <!-- Título -->
                <h1 class="text-2xl font-bold text-gray-900 mb-4">
                    Pré-Cadastro Enviado com Sucesso!
                </h1>

                <!-- Matrícula -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-gray-600 mb-1">Sua matrícula provisória é:</p>
                    <p class="text-2xl font-bold text-blue-600">{{ session('matricula') }}</p>
                </div>

                <!-- Mensagem -->
                <div class="text-left space-y-3 mb-8">
                    <p class="text-gray-700">
                        Seu pré-cadastro foi recebido e está aguardando validação do setor de Recursos Humanos.
                    </p>
                    <p class="text-gray-700">
                        Você será contatado através do telefone ou e-mail informado assim que o processo for concluído.
                    </p>
                </div>

                <!-- Próximos Passos -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left">
                    <h3 class="font-semibold text-gray-900 mb-3">Próximos Passos:</h3>
                    <ol class="list-decimal list-inside space-y-2 text-sm text-gray-700">
                        <li>Aguarde o contato do RH</li>
                        <li>Prepare os documentos originais</li>
                        <li>Compareça à sede quando solicitado</li>
                    </ol>
                </div>

                <!-- Botão -->
                <a href="{{ route('pre-cadastro.index') }}"
                   class="inline-block w-full px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Fazer Novo Pré-Cadastro
                </a>

                <!-- Informações de Contato -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <p class="text-sm text-gray-600">
                        Dúvidas? Entre em contato com o RH<br>
                        <span class="font-semibold">5º Distrito de Infraestrutura de Magé</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
