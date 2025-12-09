#!/bin/bash

echo "================================================"
echo "  🔧 CORREÇÃO: Tabela Notifications"
echo "  Sistema RH - 5º Distrito"
echo "================================================"
echo ""

# Cores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Função para verificar se comando foi bem sucedido
check_success() {
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✅ $1${NC}"
    else
        echo -e "${RED}❌ Erro: $1${NC}"
        exit 1
    fi
}

echo "📝 Passo 1: Criando migration de notificações..."
php artisan notifications:table 2>/dev/null
check_success "Migration criada"

echo ""
echo "⚡ Passo 2: Executando migrations..."
php artisan migrate --force
check_success "Migrations executadas"

echo ""
echo "🧹 Passo 3: Limpando caches..."
php artisan config:clear >/dev/null 2>&1
php artisan cache:clear >/dev/null 2>&1
php artisan route:clear >/dev/null 2>&1
php artisan view:clear >/dev/null 2>&1
check_success "Caches limpos"

echo ""
echo "🔍 Passo 4: Verificando tabelas no banco de dados..."
echo ""

# Verificar cada tabela
php artisan tinker --execute="
\$tables = [
    'notifications' => 'Notificações',
    'funcionarios' => 'Funcionários',
    'dependentes' => 'Dependentes',
    'documentos' => 'Documentos',
    'folha_ponto' => 'Folha de Ponto',
    'users' => 'Usuários'
];

echo '┌─────────────────────────────┬──────────┐' . PHP_EOL;
echo '│ Tabela                      │ Status   │' . PHP_EOL;
echo '├─────────────────────────────┼──────────┤' . PHP_EOL;

foreach (\$tables as \$table => \$nome) {
    \$exists = Schema::hasTable(\$table);
    \$status = \$exists ? '✅ OK   ' : '❌ FALTA';
    printf('│ %-27s │ %-8s │' . PHP_EOL, \$nome, \$status);
}

echo '└─────────────────────────────┴──────────┘' . PHP_EOL;
echo PHP_EOL;

// Estatísticas
if (Schema::hasTable('users')) {
    echo '📊 Total de usuários: ' . \App\Models\User::count() . PHP_EOL;
}
if (Schema::hasTable('funcionarios')) {
    echo '📊 Total de funcionários: ' . \App\Models\Funcionario::count() . PHP_EOL;
}
"

echo ""
echo "================================================"
echo -e "  ${GREEN}✅ CORREÇÃO CONCLUÍDA COM SUCESSO!${NC}"
echo "================================================"
echo ""
echo "🚀 Próximos passos:"
echo "   1. Execute: php artisan serve"
echo "   2. Acesse: http://localhost:8000/admin"
echo ""
echo "📧 Login padrão:"
echo "   Email: admin@5distrito.gov.br"
echo "   Senha: admin123"
echo ""
