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

## 📚 Documentação da API

### Base URL

```
http://localhost:8000/api/v1
```

### Autenticação

#### Registrar usuário

```http
POST /register
Content-Type: application/json

{
  "name": "Nome do Usuário",
  "email": "email@exemplo.com",
  "password": "senha123",
  "password_confirmation": "senha123"
}
```

#### Login

```http
POST /login
Content-Type: application/json

{
  "email": "email@exemplo.com",
  "password": "senha123"
}
```

#### Logout

```http
POST /logout
Authorization: Bearer {token}
```

### Livros

#### Listar livros (público)

```http
GET /books?search=termo&category_id=1&author_id=1&status=disponivel&page=1&per_page=15
```

#### Obter livro específico (público)

```http
GET /books/{id}
```

#### Livros disponíveis (público)

```http
GET /books/disponveis
```

#### Criar livro (requer autenticação)

```http
POST /books
Authorization: Bearer {token}
Content-Type: application/json

{
  "titulo": "Título do Livro",
  "isbn": "9788535902777",
  "author_id": 1,
  "category_id": 1,
  "ano_publicacao": 2023,
  "editora": "Editora",
  "numero_paginas": 200,
  "quantidade_total": 5,
  "localizacao": "Estante A, Prateleira 1",
  "descricao": "Descrição do livro"
}
```

#### Atualizar livro (requer autenticação)

```http
PUT /books/{id}
Authorization: Bearer {token}
```

#### Deletar livro (requer autenticação)

```http
DELETE /books/{id}
Authorization: Bearer {token}
```

### Autores

#### Listar autores (público)

```http
GET /authors
```

#### Obter autor específico (público)

```http
GET /authors/{id}
```

#### Criar autor (requer autenticação)

```http
POST /authors
Authorization: Bearer {token}
Content-Type: application/json

{
  "nome": "Nome",
  "sobrenome": "Sobrenome",
  "nacionalidade": "Brasileira",
  "data_nascimento": "1990-01-01",
  "biografia": "Biografia do autor"
}
```

### Categorias

#### Listar categorias (público)

```http
GET /categories
```

#### Criar categoria (requer autenticação)

```http
POST /categories
Authorization: Bearer {token}
Content-Type: application/json

{
  "nome": "Nome da Categoria",
  "descricao": "Descrição da categoria"
}
```

### Empréstimos

#### Listar empréstimos (requer autenticação)

```http
GET /emprestimos?status=ativo&user_id=1&book_id=1&atrasados=true
Authorization: Bearer {token}
```

#### Criar empréstimo (requer autenticação)

```http
POST /emprestimos
Authorization: Bearer {token}
Content-Type: application/json

{
  "book_id": 1,
  "user_id": 1,
  "data_prevista_devolucao": "2024-12-31",
  "observacoes": "Observações opcionais"
}
```

#### Meus empréstimos

```http
GET /emprestimos/meus?status=ativo
Authorization: Bearer {token}
```

#### Empréstimos atrasados

```http
GET /emprestimos/atrasados
Authorization: Bearer {token}
```

#### Devolver livro

```http
POST /emprestimos/{id}/devolver
Authorization: Bearer {token}
```

#### Renovar empréstimo

```http
POST /emprestimos/{id}/renovar
Authorization: Bearer {token}
Content-Type: application/json

{
  "data_prevista_devolucao": "2024-12-31"
}
```

#### Relatório de empréstimos

```http
GET /emprestimos/relatorio
Authorization: Bearer {token}
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

## 📱 Frontend

Esta API foi desenvolvida para ser consumida por aplicações frontend como:

- React.js
- Vue.js
- Angular
- React Native
- Flutter

As configurações de CORS estão preparadas para integração com essas tecnologias rodando nas portas padrão de desenvolvimento.

## 🤝 Contribuição

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📄 Licença

Este projeto está sob a licença MIT.
