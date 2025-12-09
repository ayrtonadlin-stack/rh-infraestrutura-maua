# 🏢 Sistema de Gestão de RH - 5º Distrito de Infraestrutura de Magé

[![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![FilamentPHP](https://img.shields.io/badge/Filament-3.2-orange.svg)](https://filamentphp.com)
[![License](https://img.shields.io/badge/license-Proprietário-green.svg)]()

Sistema completo de gerenciamento de recursos humanos desenvolvido com Laravel 11, FilamentPHP v3 e DomPDF para modernizar o setor de RH do 5º Distrito de Infraestrutura de Magé.

---

## 📚 Índice

- [Sobre o Projeto](#sobre-o-projeto)
- [Funcionalidades](#funcionalidades)
- [Tecnologias](#tecnologias)
- [Requisitos](#requisitos)
- [Instalação](#instalação)
- [Configuração](#configuração)
- [Estrutura do Projeto](#estrutura-do-projeto)
- [Como Usar](#como-usar)
- [PDFs Gerados](#pdfs-gerados)
- [Troubleshooting](#troubleshooting)
- [Contribuindo](#contribuindo)
- [Suporte](#suporte)

---

## 🎯 Sobre o Projeto

O sistema foi desenvolvido para:

✅ **Centralizar** cadastros de funcionários em plataforma digital  
✅ **Automatizar** controle de frequência (folha de ponto)  
✅ **Gerenciar** documentos digitalizados com segurança  
✅ **Gerar** fichas cadastrais e folhas de ponto em PDF  
✅ **Facilitar** pré-cadastro público de candidatos  
✅ **Seguir** rigorosamente os modelos oficiais da Secretaria

---

## 🚀 Funcionalidades

### 1️⃣ Módulo de Pré-Cadastro (Público)

- ✅ Formulário web responsivo para candidatos
- ✅ Upload de documentos básicos (Foto 3x4, RG, CPF)
- ✅ Validação automática de CPF único
- ✅ Geração automática de matrícula provisória
- ✅ Página de confirmação com instruções

**URL:** `/pre-cadastro`

### 2️⃣ Painel Administrativo (FilamentPHP)

#### Dashboard com Estatísticas
- Total de funcionários cadastrados
- Funcionários ativos vs inativos
- Pré-cadastros pendentes de validação
- Gráficos de evolução

#### Gestão Completa de Funcionários
- ✅ Cadastro completo com 50+ campos
- ✅ Validação de CPF único
- ✅ Status: Pendente, Ativo, Inativo, Rejeitado
- ✅ Busca e filtros avançados
- ✅ Exportação de dados

#### Gestão de Dependentes
- ✅ Cadastro de filhos/cônjuges
- ✅ Cálculo automático de idade
- ✅ Relacionamento 1:N com funcionário

#### Gestão de Documentos
- ✅ Upload de 15 tipos de documentos
- ✅ Armazenamento seguro
- ✅ Preview e download
- ✅ Controle de tamanho e tipo de arquivo

**URL:** `/admin`

### 3️⃣ Geração de Documentos PDF

#### Ficha Cadastral
- Layout profissional A4
- Todos os dados do funcionário
- Lista de dependentes
- Assinaturas de validação

#### Folha de Ponto
- **Layout oficial da Secretaria de Magé**
- Formato A4 vertical (portrait)
- Cabeçalho com logo e endereço completo
- Grid com 30 dias do mês
- Colunas: Dia | Entrada | Assinatura | Saída | Entrada | Assinatura | Saída
- Fins de semana identificados automaticamente
- Seção "REFEIÇÃO/DESCANSO"
- Campos para assinaturas e observações

### 4️⃣ Controle de Frequência

- ✅ Criação de folha de ponto mensal
- ✅ Estrutura JSON para armazenamento
- ✅ Identificação automática de finais de semana
- ✅ Status de fechamento
- ✅ Geração de PDF para impressão

---

## 💻 Tecnologias

| Tecnologia | Versão | Finalidade |
|------------|--------|------------|
| **Laravel** | 11.x | Framework Backend |
| **PHP** | 8.2+ | Linguagem de Programação |
| **FilamentPHP** | 3.2 | Painel Administrativo |
| **MySQL/PostgreSQL** | 8.0+/13+ | Banco de Dados |
| **DomPDF** | 2.0 | Geração de PDFs |
| **Livewire** | 3.x | Interatividade Frontend |
| **Alpine.js** | 3.x | JavaScript Reativo |
| **Tailwind CSS** | 3.x | Estilização |

---

## 📋 Requisitos

### Servidor

- **PHP:** 8.2 ou superior
- **Composer:** 2.x
- **MySQL:** 8.0+ ou **PostgreSQL:** 13+
- **Node.js:** 18+ (opcional, para compilar assets)
- **Apache/Nginx** com mod_rewrite habilitado

### Extensões PHP Necessárias

```bash
- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML
- GD (para manipulação de imagens)
```

---

## ⚡ Instalação

### Passo 1: Clone ou Crie o Projeto

```bash
# Opção A: Criar novo projeto Laravel
composer create-project laravel/laravel rh-5distrito
cd rh-5distrito

# Opção B: Clonar repositório existente
git clone [seu-repositorio]
cd rh-5distrito
```

### Passo 2: Instalar Dependências

```bash
# Instalar Filament
composer require filament/filament:"^3.2" -W

# Instalar DomPDF
composer require barryvdh/laravel-dompdf

# Atualizar autoload
composer dump-autoload
```

### Passo 3: Configurar Ambiente

```bash
# Copiar arquivo de configuração
cp .env.example .env

# Gerar chave da aplicação
php artisan key:generate
```

Edite o arquivo `.env` com suas configurações:

```env
APP_NAME="Sistema RH - 5º Distrito"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seu-dominio.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rh_5distrito
DB_USERNAME=root
DB_PASSWORD=sua_senha

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

### Passo 4: Criar Banco de Dados

```bash
# MySQL
mysql -u root -p
CREATE DATABASE rh_5distrito CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;

# PostgreSQL
psql -U postgres
CREATE DATABASE rh_5distrito;
\q
```

### Passo 5: Executar Migrations

```bash
# Criar tabela de notificações
php artisan notifications:table

# Executar todas as migrations
php artisan migrate
```

### Passo 6: Configurar Storage

```bash
# Criar link simbólico
php artisan storage:link

# Criar diretórios necessários
mkdir -p storage/app/public/documentos
mkdir -p storage/backups

# Ajustar permissões
chmod -R 775 storage bootstrap/cache
```

### Passo 7: Criar Usuário Admin

```bash
php artisan make:filament-user
```

**Informações:**
- Nome: Administrador
- Email: admin@5distrito.gov.br
- Senha: (sua senha segura)

### Passo 8: Popular Dados de Exemplo (Opcional)

```bash
php artisan db:seed --class=FuncionarioSeeder
```

### Passo 9: Limpar Caches

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### Passo 10: Iniciar Servidor

```bash
# Desenvolvimento
php artisan serve

# Produção (configurar Nginx/Apache)
```

---

## 🔧 Configuração

### Estrutura de Arquivos Importantes

```
rh-5distrito/
├── app/
│   ├── Filament/              # Recursos do Filament
│   ├── Helpers/               # Funções auxiliares
│   ├── Http/Controllers/      # Controllers
│   ├── Models/                # Models Eloquent
│   └── Providers/             # Service Providers
├── config/                    # Arquivos de configuração
├── database/
│   ├── migrations/            # Migrations do banco
│   └── seeders/               # Seeders
├── resources/
│   └── views/
│       ├── pdf/               # Templates PDF
│       └── pre-cadastro/      # Formulário público
├── routes/
│   └── web.php                # Rotas web
├── storage/
│   └── app/public/documentos/ # Documentos upload
└── .env                       # Configurações
```

### Ajustar Configurações de Upload

Edite `config/filesystems.php` (já incluído no projeto)

### Ajustar Limites de Upload

Edite `php.ini`:

```ini
upload_max_filesize = 10M
post_max_size = 10M
memory_limit = 256M
max_execution_time = 300
```

Ou via `.htaccess` (já incluído):

```apache
php_value upload_max_filesize 10M
php_value post_max_size 10M
```

---

## 📂 Estrutura do Projeto

### Models (app/Models/)

- **Funcionario.php** - Dados principais do funcionário
- **Dependente.php** - Dependentes (filhos, cônjuge)
- **Documento.php** - Documentos anexados
- **FolhaPonto.php** - Registros de frequência
- **User.php** - Usuários do sistema

### Controllers (app/Http/Controllers/)

- **PreCadastroController.php** - Pré-cadastro público
- **FolhaPontoController.php** - Gestão de ponto (opcional)

### Filament Resources (app/Filament/Resources/)

- **FuncionarioResource.php** - CRUD completo
  - **Pages/** - Páginas customizadas
  - **RelationManagers/** - Gestão de relacionamentos

### Views (resources/views/)

- **pdf/ficha-cadastral.blade.php** - Template da ficha
- **pdf/folha-ponto.blade.php** - Template da folha de ponto (modelo oficial)
- **pre-cadastro/index.blade.php** - Formulário público
- **pre-cadastro/sucesso.blade.php** - Confirmação

---

## 📖 Como Usar

### Para Candidatos (Pré-Cadastro)

1. Acesse `/pre-cadastro`
2. Preencha todos os campos obrigatórios
3. Faça upload dos documentos (Foto 3x4, RG, CPF)
4. Clique em "Enviar Pré-Cadastro"
5. Anote sua matrícula provisória
6. Aguarde contato do RH

### Para Administradores RH

#### 1. Acessar o Sistema

```
URL: /admin
Login com credenciais criadas
```

#### 2. Validar Pré-Cadastros

```
1. Menu "Funcionários"
2. Filtrar por status "Pendente"
3. Clicar em "Editar"
4. Revisar dados e documentos
5. Completar informações faltantes
6. Alterar status para "Ativo" ou "Rejeitado"
```

#### 3. Gerar Ficha Cadastral

```
1. Entrar na edição do funcionário
2. Clicar em "Imprimir Ficha Cadastral"
3. PDF será gerado e baixado automaticamente
```

#### 4. Criar Folha de Ponto

```
1. Entrar na edição do funcionário
2. Clicar em "Folha de Ponto"
3. Selecionar mês e ano
4. Clicar em "Submit"
5. PDF será gerado no modelo oficial
```

#### 5. Adicionar Dependentes

```
1. Editar funcionário
2. Aba "Dependentes"
3. Clicar em "Criar"
4. Preencher nome, data de nascimento e tipo
5. Salvar
```

#### 6. Upload de Documentos

```
1. Editar funcionário
2. Aba "Documentos"
3. Clicar em "Criar"
4. Selecionar tipo de documento
5. Fazer upload (PDF ou imagem, máx. 5MB)
6. Salvar
```

---

## 📄 PDFs Gerados

### 1. Ficha Cadastral

**Layout:** A4 Retrato (portrait)

**Seções:**
- Cabeçalho com título
- Identificação completa
- Documentação básica e legal
- Endereço e contato
- Filiação
- Uniforme e dados bancários
- Lista de dependentes
- Assinaturas de validação

**Uso:** Arquivo oficial do funcionário

---

### 2. Folha de Ponto

**Layout:** A4 Retrato (portrait) - **MODELO OFICIAL**

**Características:**
- ✅ Logo "MAGÉ" e endereço da Secretaria
- ✅ Campos: Nome, Função, Matrícula, Equipe, Mês/Ano
- ✅ Campo "Encarregado"
- ✅ Campo "Horário"
- ✅ Linha "DISTRITO DE LOTAÇÃO: 5º DISTRITO"
- ✅ Linha "DIRETOR: HELIO SANDRO VICENTE DA SILVA"
- ✅ Seção "REFEIÇÃO/DESCANSO"
- ✅ Grid com 30 dias
- ✅ 7 colunas: Dia | Entrada | Assinatura | Saída | Entrada | Assinatura | Saída
- ✅ Sábados e Domingos marcados automaticamente
- ✅ Rodapé com linhas para assinaturas
- ✅ Campo "OBS:"

**Formato:** Idêntico ao modelo físico usado pela Secretaria

**Uso:** Controle mensal de frequência

---

## 🔧 Troubleshooting

### ❌ Erro: Table 'notifications' doesn't exist

**Solução:**
```bash
php artisan notifications:table
php artisan migrate
php artisan config:clear
```

### ❌ Erro: 405 Method Not Allowed (Login)

**Solução:**
```bash
php artisan route:clear
php artisan config:clear
php artisan filament:upgrade
```

### ❌ Erro: Storage link not found

**Solução:**
```bash
php artisan storage:link
chmod -R 775 storage
```

### ❌ Erro: PDFs não geram

**Solução:**
```bash
composer require barryvdh/laravel-dompdf
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
php artisan config:clear
```

### ❌ Erro: Permissão negada

**Solução:**
```bash
chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

### 📚 Documentação Completa

Consulte os arquivos de troubleshooting:
- `TROUBLESHOOTING.md` - Soluções detalhadas
- `INSTALLATION.md` - Guia completo de instalação
- `HOSTING.md` - Deploy em hospedagem compartilhada

---

## 🌐 Deploy em Produção

### Checklist

```bash
# 1. Otimizar
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# 2. Ajustar .env
APP_ENV=production
APP_DEBUG=false

# 3. Permissões
chmod -R 755 storage bootstrap/cache

# 4. Backup
# Configure backup automático
```

### Servidor Recomendado

- **Apache/Nginx** com PHP-FPM
- **PHP 8.2+** com extensões necessárias
- **MySQL 8.0+** ou **PostgreSQL 13+**
- **Composer 2.x**
- **SSL/TLS** válido
- **Supervisor** para filas (opcional)

### Hospedagem Compartilhada

Consulte `HOSTING.md` para instruções específicas.

**⚠️ Importante:** Hospedagens gratuitas podem ter limitações. Recomenda-se VPS ou hospedagem Laravel dedicada.

---

## 📊 Estatísticas do Projeto

- **Linhas de Código:** ~4.500
- **Arquivos:** 57 arquivos essenciais
- **Models:** 5
- **Migrations:** 5
- **Controllers:** 2
- **Views:** 6
- **PDFs:** 2 templates
- **Campos no Formulário:** 50+
- **Tipos de Documentos:** 15

---

## 🤝 Contribuindo

Este é um projeto interno do 5º Distrito de Infraestrutura de Magé.

Para sugestões de melhorias:
1. Documente o problema/melhoria
2. Entre em contato com a equipe de TI
3. Aguarde análise de viabilidade

---

## 📞 Suporte

**Desenvolvido para:**  
5º Distrito de Infraestrutura de Magé  
Secretaria de Recursos Humanos

**Endereço:**  
Rua Paulo Teixeira dos Santos, N.º 75  
CEP 25935-082 - Magé/RJ

**Contato:**  
📧 rh@5distrito.mage.rj.gov.br  
📱 (21) 2633-XXXX

---

## 📝 Licença

Sistema proprietário do 5º Distrito de Infraestrutura de Magé.  
Todos os direitos reservados © 2024

---

## 🎉 Agradecimentos

Desenvolvido com as tecnologias open-source:
- [Laravel Framework](https://laravel.com)
- [FilamentPHP](https://filamentphp.com)
- [DomPDF](https://github.com/barryvdh/laravel-dompdf)
- [Livewire](https://livewire.laravel.com)
- [Alpine.js](https://alpinejs.dev)
- [Tailwind CSS](https://tailwindcss.com)

---

## 📚 Links Úteis

- **Documentação Laravel:** https://laravel.com/docs
- **Documentação Filament:** https://filamentphp.com/docs
- **Documentação DomPDF:** https://github.com/barryvdh/laravel-dompdf

---

## 🔄 Histórico de Versões

### Versão 1.0 (28/11/2024)
- ✅ Lançamento inicial
- ✅ CRUD completo de funcionários
- ✅ Sistema de pré-cadastro
- ✅ Gestão de documentos
- ✅ Geração de PDFs (Ficha Cadastral e Folha de Ponto)
- ✅ Template de Folha de Ponto no modelo oficial da Secretaria
- ✅ Dashboard com estatísticas
- ✅ Sistema de permissões básico

---

**Versão:** 1.0  
**Data de Release:** 28/11/2024  
**Última Atualização:** 28/11/2024  
**Status:** ✅ Produção

---

<div align="center">

**Feito com ❤️ para o 5º Distrito de Infraestrutura de Magé**

[📖 Documentação](https://github.com/seu-repo/wiki) | [🐛 Reportar Bug](https://github.com/seu-repo/issues) | [💡 Sugerir Feature](https://github.com/seu-repo/issues)

</div>

---

## 🎯 Visão Geral

O sistema foi desenvolvido para:

✅ **Centralizar** cadastros de funcionários em plataforma digital  
✅ **Automatizar** controle de frequência (folha de ponto)  
✅ **Gerenciar** documentos digitalizados com segurança  
✅ **Gerar** fichas cadastrais e folhas de ponto em PDF  
✅ **Facilitar** pré-cadastro público de candidatos  

---

## 🚀 Recursos Implementados

### 1️⃣ Módulo de Pré-Cadastro (Público)

- ✅ Formulário web responsivo para candidatos
- ✅ Upload de documentos básicos (Foto 3x4, RG, CPF)
- ✅ Validação automática de CPF
- ✅ Geração de matrícula provisória
- ✅ Página de confirmação com instruções

**URL:** `/pre-cadastro`

### 2️⃣ Painel Administrativo (FilamentPHP)

#### Dashboard com Estatísticas
- Total de funcionários cadastrados
- Funcionários ativos vs inativos
- Pré-cadastros pendentes de validação
- Gráficos de evolução

#### Gestão Completa de Funcionários
- ✅ Cadastro completo com 50+ campos
- ✅ Validação de CPF único
- ✅ Status: Pendente, Ativo, Inativo, Rejeitado
- ✅ Busca e filtros avançados
- ✅ Exportação de dados

#### Gestão de Dependentes
- ✅ Cadastro de filhos/cônjuges
- ✅ Cálculo automático de idade
- ✅ Relacionamento 1:N com funcionário

#### Gestão de Documentos
- ✅ Upload de 15 tipos de documentos
- ✅ Armazenamento seguro
- ✅ Preview e download
- ✅ Controle de tamanho e tipo de arquivo

**URL:** `/admin`

### 3️⃣ Geração de Documentos PDF

#### Ficha Cadastral
- Layout profissional A4
- Todos os dados do funcionário
- Lista de dependentes
- Assinaturas de validação

#### Folha de Ponto
- Layout A4 paisagem
- Grid com 31 dias do mês
- Campos: Entrada, Saída Refeição, Retorno, Saída
- Fins de semana identificados automaticamente
- Área de assinaturas

### 4️⃣ Controle de Frequência

- ✅ Criação de folha de ponto mensal
- ✅ Estrutura JSON para armazenamento
- ✅ Identificação automática de finais de semana
- ✅ Status de fechamento
- ✅ Geração de PDF para impressão

---

## 💻 Tecnologias Utilizadas

| Tecnologia | Versão | Finalidade |
|------------|--------|------------|
| **Laravel** | 11.x | Framework Backend |
| **PHP** | 8.2+ | Linguagem de Programação |
| **FilamentPHP** | 3.x | Painel Administrativo |
| **MySQL/PostgreSQL** | 8.0+/13+ | Banco de Dados |
| **DomPDF** | - | Geração de PDFs |
| **Livewire** | 3.x | Interatividade Frontend |
| **Alpine.js** | 3.x | JavaScript Reativo |
| **Tailwind CSS** | 3.x | Estilização |

---

## ⚡ Instalação Rápida

### Pré-requisitos

```bash
php -v    # PHP 8.2+
composer --version
mysql --version
node -v   # Node.js 18+
```

### Passo a Passo

```bash
# 1. Clone ou crie o projeto
composer create-project laravel/laravel rh-5distrito
cd rh-5distrito

# 2. Instale as dependências
composer require filament/filament:"^3.0"
composer require barryvdh/laravel-dompdf

# 3. Configure o .env
cp .env.example .env
php artisan key:generate

# Edite o .env com suas credenciais do banco

# 4. Crie o banco de dados
mysql -u root -p
CREATE DATABASE rh_5distrito;
EXIT;

# 5. Execute as migrations
php artisan migrate

# 6. Instale o Filament
php artisan filament:install --panels

# 7. Crie o usuário admin
php artisan make:filament-user
# Email: admin@5distrito.gov.br
# Password: sua_senha_segura

# 8. Crie link simbólico do storage
php artisan storage:link

# 9. (Opcional) Popule com dados de exemplo
php artisan db:seed --class=FuncionarioSeeder

# 10. Inicie o servidor
php artisan serve
```

Acesse:
- **Pré-cadastro:** http://localhost:8000/pre-cadastro
- **Admin:** http://localhost:8000/admin

---

## 📂 Estrutura do Projeto

```
rh-5distrito/
│
├── app/
│   ├── Filament/
│   │   ├── Resources/
│   │   │   ├── FuncionarioResource.php
│   │   │   └── FuncionarioResource/
│   │   │       ├── Pages/
│   │   │       │   ├── ListFuncionarios.php
│   │   │       │   ├── CreateFuncionario.php
│   │   │       │   └── EditFuncionario.php
│   │   │       └── RelationManagers/
│   │   │           ├── DependentesRelationManager.php
│   │   │           └── DocumentosRelationManager.php
│   │   └── Widgets/
│   │       └── FuncionarioStatsWidget.php
│   │
│   ├── Http/Controllers/
│   │   ├── PreCadastroController.php
│   │   └── FolhaPontoController.php
│   │
│   └── Models/
│       ├── Funcionario.php
│       ├── Dependente.php
│       ├── Documento.php
│       └── FolhaPonto.php
│
├── database/
│   ├── migrations/
│   │   ├── create_funcionarios_table.php
│   │   ├── create_dependentes_table.php
│   │   ├── create_documentos_table.php
│   │   └── create_folha_ponto_table.php
│   └── seeders/
│       └── FuncionarioSeeder.php
│
├── resources/
│   └── views/
│       ├── pre-cadastro/
│       │   ├── index.blade.php
│       │   └── sucesso.blade.php
│       └── pdf/
│           ├── ficha-cadastral.blade.php
│           └── folha-ponto.blade.php
│
└── routes/
    └── web.php
```

---

## 📖 Guia de Uso

### Para Candidatos (Pré-Cadastro)

1. Acesse `/pre-cadastro`
2. Preencha todos os campos obrigatórios
3. Faça upload dos documentos (Foto 3x4, RG, CPF)
4. Clique em "Enviar Pré-Cadastro"
5. Anote sua matrícula provisória
6. Aguarde contato do RH

### Para Administradores RH

#### Validar Pré-Cadastros

1. Acesse `/admin` e faça login
2. Vá em "Funcionários"
3. Filtre por status "Pendente"
4. Clique em "Editar" no funcionário
5. Revise os dados e documentos
6. Complete informações faltantes
7. Altere status para "Ativo" ou "Rejeitado"

#### Gerar Ficha Cadastral

1. Entre na edição do funcionário
2. Clique em "Imprimir Ficha Cadastral"
3. O PDF será gerado e baixado automaticamente

#### Criar Folha de Ponto

1. Entre na edição do funcionário
2. Clique em "Gerenciar Folha de Ponto"
3. Selecione mês e ano
4. Clique em "Submit"
5. O PDF será gerado com o grid do mês

#### Adicionar Dependentes

1. Entre na edição do funcionário
2. Role até a aba "Dependentes"
3. Clique em "Criar"
4. Preencha nome, data de nascimento e tipo
5. Salve

#### Fazer Upload de Documentos

1. Entre na edição do funcionário
2. Role até a aba "Documentos"
3. Clique em "Criar"
4. Selecione o tipo de documento
5. Faça upload do arquivo (PDF ou imagem, máx. 5MB)
6. Salve

---

## 🛣️ API e Rotas

### Rotas Públicas

```php
GET  /pre-cadastro         # Formulário de pré-cadastro
POST /pre-cadastro         # Enviar pré-cadastro
GET  /pre-cadastro/sucesso # Página de confirmação
```

### Rotas Administrativas (Protegidas)

```php
# Painel Filament
GET  /admin               # Dashboard
GET  /admin/login         # Login
GET  /admin/funcionarios  # Lista de funcionários
POST /admin/funcionarios  # Criar funcionário
GET  /admin/funcionarios/{id}/edit  # Editar
PUT  /admin/funcionarios/{id}       # Atualizar
DELETE /admin/funcionarios/{id}     # Excluir

# Folha de Ponto
GET  /funcionarios/{id}/folha-ponto              # Listar folhas
POST /funcionarios/{id}/folha-ponto              # Criar folha
GET  /funcionarios/{id}/folha-ponto/{folha}/pdf  # Gerar PDF
```

---

## 🗄️ Banco de Dados

### Tabela: funcionarios

Campos principais:
- `id`, `matricula`, `nome_completo`, `funcao`, `status`
- `cpf`, `rg_numero`, `rg_orgao_emissor`, `rg_data_expedicao`
- `data_nascimento`, `nacionalidade`, `estado_civil`
- `endereco_*` (logradouro, numero, bairro, cep, municipio, uf)
- `telefone_*`, `email`
- `pis_pasep`, `ctps_*`, `titulo_eleitor`, `cnh_*`, `certificado_reservista`
- `grau_instrucao`, `nome_pai`, `nome_mae`, `filiacao_uf`
- `uniforme_*`, `banco`, `agencia`, `conta`
- `equipe`, `distrito`
- `timestamps`, `soft_deletes`

### Tabela: dependentes

- `id`, `funcionario_id`, `nome`, `data_nascimento`, `tipo`

### Tabela: documentos

- `id`, `funcionario_id`, `tipo`, `arquivo_nome`, `arquivo_path`, `arquivo_mime`, `arquivo_tamanho`

### Tabela: folha_ponto

- `id`, `funcionario_id`, `mes`, `ano`, `registros` (JSON), `fechada`

---

## 📄 PDFs e Templates

### Ficha Cadastral (`resources/views/pdf/ficha-cadastral.blade.php`)

**Layout:** A4 Retrato  
**Seções:**
- Cabeçalho com título e distrito
- Identificação completa
- Documentação básica e legal
- Endereço e contato
- Filiação
- Uniforme e dados bancários
- Lista de dependentes
- Assinaturas de validação

### Folha de Ponto (`resources/views/pdf/folha-ponto.blade.php`)

**Layout:** A4 Paisagem  
**Estrutura:**
- Informações do funcionário e período
- Grid 31 dias em 3 colunas
- Campos: Entrada | Saída Ref | Retorno | Saída
- Fins de semana destacados
- Instruções de preenchimento
- 3 áreas de assinatura

---

## 🔒 Segurança

### Medidas Implementadas

✅ **Autenticação:** Apenas usuários autenticados acessam o painel admin  
✅ **Validação de CPF:** Impede duplicação de cadastros  
✅ **CSRF Protection:** Todos os formulários protegidos  
✅ **Upload Seguro:** Validação de tipo e tamanho de arquivos  
✅ **Soft Deletes:** Registros não são excluídos permanentemente  
✅ **Sanitização:** Inputs sanitizados contra XSS  

### Recomendações Adicionais

```bash
# Em produção, configure:
APP_ENV=production
APP_DEBUG=false

# Use HTTPS
# Configure firewall
# Faça backups regulares
# Mantenha Laravel e dependências atualizados
```

---

## 🚀 Deploy em Produção

### Checklist

```bash
# 1. Otimizar para produção
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# 2. Configurar permissões
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# 3. Configurar .env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seu-dominio.com

# 4. Configurar SSL/HTTPS
# (use Certbot/Let's Encrypt)

# 5. Configurar backup automático
# (use Laravel Backup ou scripts personalizados)

# 6. Configurar logs
LOG_CHANNEL=daily
LOG_LEVEL=error

# 7. Configurar filas (opcional)
QUEUE_CONNECTION=database
php artisan queue:work --daemon
```

### Servidor Recomendado

- **Apache/Nginx** com PHP-FPM
- **PHP 8.2+** com extensões: mbstring, openssl, pdo, tokenizer, xml, ctype, json, bcmath, gd
- **MySQL 8.0+** ou **PostgreSQL 13+**
- **Composer 2.x**
- **Supervisor** para gerenciar filas
- **SSL/TLS** válido

---

## 🐛 Solução de Problemas

### Erro: "Class 'Barryvdh\DomPDF\Facade\Pdf' not found"

```bash
composer require barryvdh/laravel-dompdf
php artisan config:clear
```

### Erro: Storage não encontrado

```bash
php artisan storage:link
chmod -R 775 storage
```

### Erro: Permissão negada

```bash
sudo chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

### PDFs não renderizam corretamente

```bash
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
# Edite config/dompdf.php se necessário
```

---

## 📊 Estatísticas do Projeto

- **Linhas de Código:** ~3.500
- **Modelos:** 4 (Funcionario, Dependente, Documento, FolhaPonto)
- **Migrations:** 4
- **Controllers:** 2
- **Views:** 4
- **PDFs:** 2 templates
- **Campos no Formulário:** 50+
- **Tipos de Documentos:** 15

---

## 🤝 Contribuindo

Este é um projeto interno do 5º Distrito de Infraestrutura de Magé.

Para sugestões de melhorias:
1. Documente o problema/melhoria
2. Entre em contato com a equipe de TI
3. Aguarde análise de viabilidade

---

## 📞 Suporte

**Desenvolvido para:**  
5º Distrito de Infraestrutura de Magé  
Secretaria de Recursos Humanos

**Contato:**  
📧 rh@5distrito.mage.rj.gov.br  
📱 (21) 2633-XXXX

---

## 📝 Licença

Sistema proprietário do 5º Distrito de Infraestrutura de Magé.  
Todos os direitos reservados © 2024

---

## 🎉 Agradecimentos

Desenvolvido com as tecnologias open-source:
- Laravel Framework
- FilamentPHP
- DomPDF
- Livewire
- Alpine.js
- Tailwind CSS

**Versão:** 1.0  
**Data de Release:** 28/11/2024  
**Última Atualização:** 28/11/2024
