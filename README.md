# API Biblioteca - Sistema de Empréstimos

Sistema de gerenciamento de biblioteca desenvolvido em Laravel, funcionando apenas como API backend.

## 🚀 Funcionalidades

- **Autenticação**: Registro e login de usuários com Laravel Sanctum
- **Gestão de Livros**: CRUD completo de livros
- **Gestão de Autores**: CRUD completo de autores
- **Gestão de Categorias**: CRUD completo de categorias
- **Sistema de Empréstimos**: Controle completo de empréstimos e devoluções
- **Controle de Multas**: Cálculo automático de multas por atraso
- **Relatórios**: Dashboard com estatísticas dos empréstimos

## 📋 Pré-requisitos

- PHP 8.2+
- Composer
- SQLite (configuração padrão)

## 🔧 Instalação

1. Clone o repositório
2. Instale as dependências:
   ```bash
   composer install
   ```

3. Configure o ambiente:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Execute as migrações e seeders:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. Inicie o servidor:
   ```bash
   php artisan serve
   ```

## 📊 Dados de Teste

O sistema vem com dados de exemplo:

- **Usuário administrador**: admin@biblioteca.com / password
- **8 livros** de diferentes categorias
- **8 autores** famosos
- **10 categorias** variadas

## 🔒 Configurações de Segurança

- CORS configurado para desenvolvimento local
- Sanctum para autenticação stateful/stateless
- Validações em todos os endpoints
- Proteção contra empréstimos duplicados
- Verificação de disponibilidade de livros

## 🛠️ Tecnologias Utilizadas

- **Laravel 12**: Framework PHP
- **Laravel Sanctum**: Autenticação de API
- **SQLite**: Banco de dados (padrão)
- **Eloquent ORM**: Mapeamento objeto-relacional

# Como Importar e Usar a Coleção do Postman

## 📥 Importação dos Arquivos

### 1. Importar a Coleção
1. Abra o Postman
2. Clique em **"Import"** (botão no canto superior esquerdo)
3. Selecione o arquivo `postman_collection.json`
4. Clique em **"Import"**

### 2. Importar o Environment
1. No Postman, clique no ícone de engrenagem (⚙️) no canto superior direito
2. Selecione **"Manage Environments"**
3. Clique em **"Import"**
4. Selecione o arquivo `postman_environment.json`
5. Clique em **"Import"**

### 3. Ativar o Environment
1. No dropdown no canto superior direito, selecione **"Biblioteca API - Local"**

## 🚀 Como Usar

### Passo 1: Verificar Status da API
- Execute a requisição **"Status da API"** na pasta **"Autenticação"**
- Deve retornar status 200 com informações da API

### Passo 2: Fazer Login
1. Execute a requisição **"Login"** na pasta **"Autenticação"**
2. O token será automaticamente salvo na variável `auth_token`
3. Todas as requisições protegidas usarão este token automaticamente

### Passo 3: Testar Endpoints Públicos
- **Listar Livros**: Veja todos os livros cadastrados
- **Livros Disponíveis**: Apenas livros disponíveis para empréstimo
- **Listar Autores**: Todos os autores cadastrados
- **Listar Categorias**: Todas as categorias

### Passo 4: Testar Endpoints Protegidos (após login)
- **Criar Empréstimo**: Realize um empréstimo de livro
- **Meus Empréstimos**: Veja empréstimos do usuário logado
- **Relatórios**: Estatísticas dos empréstimos

## 📝 Dados de Teste Disponíveis

### Usuário Administrador
- **Email**: admin@biblioteca.com
- **Senha**: password

## 📄 Licença

Este projeto está sob a licença MIT.
