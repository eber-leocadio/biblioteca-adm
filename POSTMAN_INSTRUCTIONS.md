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

### Livros (IDs 1-8)
- Dom Casmurro (ID: 1)
- A Hora da Estrela (ID: 2)
- Cem Anos de Solidão (ID: 3)
- 1984 (ID: 4)
- Harry Potter e a Pedra Filosofal (ID: 5)
- O Iluminado (ID: 6)
- Clean Code (ID: 7)
- O Alquimista (ID: 8)

### Autores (IDs 1-8)
- Machado de Assis (ID: 1)
- Clarice Lispector (ID: 2)
- Gabriel García Márquez (ID: 3)
- George Orwell (ID: 4)
- J.K. Rowling (ID: 5)
- Stephen King (ID: 6)
- Robert Martin (ID: 7)
- Paulo Coelho (ID: 8)

### Categorias (IDs 1-10)
- Ficção (ID: 1)
- Não-ficção (ID: 2)
- Tecnologia (ID: 3)
- História (ID: 4)
- Ciência (ID: 5)
- Filosofia (ID: 6)
- Autoajuda (ID: 7)
- Biografia (ID: 8)
- Infantil (ID: 9)
- Poesia (ID: 10)

## 🔄 Fluxo de Teste Recomendado

### 1. Autenticação
1. ✅ Status da API
2. ✅ Login (salva o token automaticamente)
3. ✅ Perfil do Usuário

### 2. Consultas Públicas
1. ✅ Listar Livros
2. ✅ Buscar Livros (com filtros)
3. ✅ Livros Disponíveis
4. ✅ Listar Autores
5. ✅ Listar Categorias

### 3. Operações CRUD (requer login)
1. ✅ Criar Autor
2. ✅ Criar Categoria
3. ✅ Criar Livro
4. ✅ Atualizar dados
5. ⚠️ Deletar (cuidado com dependências)

### 4. Empréstimos (requer login)
1. ✅ Criar Empréstimo
2. ✅ Listar Empréstimos
3. ✅ Meus Empréstimos
4. ✅ Renovar Empréstimo
5. ✅ Devolver Livro
6. ✅ Relatório

## 🛠️ Personalização

### Variáveis Disponíveis
- `base_url`: URL da API (padrão: http://localhost:8000)
- `auth_token`: Token de autenticação (preenchido automaticamente no login)

### Modificar URLs
Se você estiver rodando a API em outra porta ou domínio:
1. Vá para o environment **"Biblioteca API - Local"**
2. Modifique a variável `base_url`
3. Salve as alterações

## 🚨 Dicas Importantes

1. **Sempre faça login primeiro** para testar endpoints protegidos
2. **IDs nos exemplos** são baseados nos dados de teste - ajuste conforme necessário
3. **Dependências**: Não delete autores/categorias que têm livros associados
4. **Empréstimos**: Verifique se o livro está disponível antes de emprestar
5. **Token expira**: Se receber erro 401, faça login novamente

## 📞 Suporte

Se encontrar problemas:
1. Verifique se o servidor Laravel está rodando (`php artisan serve`)
2. Verifique se o environment correto está selecionado
3. Confirme se fez login e o token está válido
4. Verifique os logs do servidor Laravel para erros detalhados
