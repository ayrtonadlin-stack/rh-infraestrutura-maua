<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pré-Cadastro - RH 5º Distrito</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Pré-Cadastro de Funcionário</h1>
                <p class="mt-2 text-gray-600">5º Distrito de Infraestrutura de Magé</p>
            </div>

            <!-- Alertas -->
            @if(session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4">
                <p class="text-red-700">{{ session('error') }}</p>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4">
                <p class="font-semibold text-red-700">Por favor, corrija os seguintes erros:</p>
                <ul class="mt-2 list-disc list-inside text-red-600">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Formulário -->
            <div class="bg-white shadow-lg rounded-lg p-8">
                <form action="{{ route('pre-cadastro.store') }}" method="POST" enctype="multipart/form-data" x-data="{ showPreview: {} }">
                    @csrf

                    <!-- Dados Pessoais -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Dados Pessoais</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nome Completo *</label>
                                <input type="text" name="nome_completo" value="{{ old('nome_completo') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">CPF *</label>
                                <input type="text" name="cpf" value="{{ old('cpf') }}" required
                                    x-mask="999.999.999-99"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Data de Nascimento *</label>
                                <input type="date" name="data_nascimento" value="{{ old('data_nascimento') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">RG - Número *</label>
                                <input type="text" name="rg_numero" value="{{ old('rg_numero') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">RG - Órgão Emissor *</label>
                                <input type="text" name="rg_orgao_emissor" value="{{ old('rg_orgao_emissor') }}" required
                                    placeholder="Ex: SSP/RJ"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Função Pretendida *</label>
                                <input type="text" name="funcao" value="{{ old('funcao') }}" required
                                    placeholder="Ex: Auxiliar Administrativo"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- Contato -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Contato</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Celular/WhatsApp *</label>
                                <input type="text" name="telefone_celular" value="{{ old('telefone_celular') }}" required
                                    x-mask="(99) 99999-9999"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">E-mail</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- Endereço -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Endereço</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">CEP *</label>
                                <input type="text" name="endereco_cep" value="{{ old('endereco_cep') }}" required
                                    x-mask="99999-999"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Logradouro *</label>
                                <input type="text" name="endereco_logradouro" value="{{ old('endereco_logradouro') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Número *</label>
                                <input type="text" name="endereco_numero" value="{{ old('endereco_numero') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Bairro *</label>
                                <input type="text" name="endereco_bairro" value="{{ old('endereco_bairro') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Município *</label>
                                <input type="text" name="endereco_municipio" value="{{ old('endereco_municipio') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">UF *</label>
                                <input type="text" name="endereco_uf" value="{{ old('endereco_uf', 'RJ') }}" required
                                    maxlength="2"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- Documentos -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Documentos Obrigatórios</h2>
                        <p class="text-sm text-gray-600 mb-4">Envie os documentos digitalizados (PDF ou imagem, máx. 2MB cada)</p>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Foto 3x4 (Recente) *</label>
                                <input type="file" name="foto" accept="image/*" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">RG (Frente e Verso) *</label>
                                <input type="file" name="documento_rg" accept="application/pdf,image/*" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">CPF *</label>
                                <input type="file" name="documento_cpf" accept="application/pdf,image/*" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Botões -->
                    <div class="flex justify-end space-x-4">
                        <button type="reset" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                            Limpar
                        </button>
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Enviar Pré-Cadastro
                        </button>
                    </div>
                </form>
            </div>

            <!-- Informações -->
            <div class="mt-6 text-center text-sm text-gray-600">
                <p>* Campos obrigatórios</p>
                <p class="mt-2">Após o envio, aguarde a validação do setor de RH.</p>
            </div>
        </div>
    </div>

    <!-- Alpine.js Mask -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.directive('mask', (el, { expression }) => {
                let mask = expression;
                el.addEventListener('input', (e) => {
                    let value = e.target.value.replace(/\D/g, '');
                    let maskedValue = '';
                    let valueIndex = 0;

                    for (let i = 0; i < mask.length && valueIndex < value.length; i++) {
                        if (mask[i] === '9') {
                            maskedValue += value[valueIndex];
                            valueIndex++;
                        } else {
                            maskedValue += mask[i];
                        }
                    }
                    e.target.value = maskedValue;
                });
            });
        });
    </script>
</body>
</html>
