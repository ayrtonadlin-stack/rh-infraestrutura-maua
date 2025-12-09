#!/bin/bash

echo "================================================"
echo "  Instalação Automática"
echo "  Sistema RH - 5º Distrito de Infraestrutura"
echo "================================================"
echo ""

# Verificar se o PHP está instalado
if ! command -v php &> /dev/null; then
    echo "❌ PHP não encontrado. Instale o PHP 8.2 ou superior."
    exit 1
fi

echo "✅ PHP $(php -v | head -n 1 | cut -d ' ' -f 2) encontrado"

# Verificar se o Composer está instalado
if ! command -v composer &> /dev/null; then
    echo "❌ Composer não encontrado. Instale o Composer."
    exit 1
fi

echo "✅ Composer encontrado"

# Verificar se o MySQL está instalado
if ! command -v mysql &> /dev/null; then
    echo "⚠️  MySQL não encontrado. Certifique-se de ter um banco de dados instalado."
fi

echo ""
echo "📦 Instalando dependências do Composer..."
composer install

echo ""
echo "📦 Instalando dependências do NPM..."
npm install

echo ""
echo "🔑 Gerando chave da aplicação..."
php artisan key:generate

echo ""
echo "📝 Copiando arquivo .env..."
if [ ! -f .env ]; then
    cp .env.example .env
    echo "✅ Arquivo .env criado"
else
    echo "⚠️  Arquivo .env já existe"
fi

echo ""
echo "📊 Configuração do Banco de Dados"
echo "=================================="
read -p "Nome do banco de dados [rh_5distrito]: " DB_NAME
DB_NAME=${DB_NAME:-rh_5distrito}

read -p "Usuário do banco [root]: " DB_USER
DB_USER=${DB_USER:-root}

read -sp "Senha do banco: " DB_PASS
echo ""

# Atualizar .env
sed -i "s/DB_DATABASE=.*/DB_DATABASE=$DB_NAME/" .env
sed -i "s/DB_USERNAME=.*/DB_USERNAME=$DB_USER/" .env
sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=$DB_PASS/" .env

echo ""
echo "🗄️  Criando banco de dados..."
mysql -u $DB_USER -p$DB_PASS -e "CREATE DATABASE IF NOT EXISTS $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

if [ $? -eq 0 ]; then
    echo "✅ Banco de dados criado/verificado"
else
    echo "❌ Erro ao criar banco de dados"
    exit 1
fi

echo ""
echo "🔄 Executando migrations..."
php artisan migrate --force

echo ""
echo "📁 Criando link simbólico do storage..."
php artisan storage:link

echo ""
echo "🔧 Criando diretórios necessários..."
mkdir -p storage/app/public/documentos
mkdir -p storage/backups
chmod -R 775 storage bootstrap/cache

echo ""
read -p "Deseja criar um usuário administrador? (s/n): " CREATE_USER
if [[ $CREATE_USER =~ ^[Ss]$ ]]; then
    php artisan make:filament-user
fi

echo ""
read -p "Deseja popular com dados de exemplo? (s/n): " SEED_DATA
if [[ $SEED_DATA =~ ^[Ss]$ ]]; then
    php artisan db:seed --class=FuncionarioSeeder
    echo "✅ Dados de exemplo inseridos"
fi

echo ""
echo "🧹 Limpando cache..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo ""
echo "================================================"
echo "  ✅ Instalação Concluída com Sucesso!"
echo "================================================"
echo ""
echo "📌 Próximos passos:"
echo "1. Inicie o servidor: php artisan serve"
echo "2. Acesse o pré-cadastro: http://localhost:8000/pre-cadastro"
echo "3. Acesse o admin: http://localhost:8000/admin"
echo ""
echo "📧 Credenciais padrão (se criou dados de exemplo):"
echo "   Email: admin@5distrito.gov.br"
echo "   Senha: admin123"
echo ""
echo "================================================"
