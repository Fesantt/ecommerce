# Tarefa: CRUD de Categorias

Branch de estudo: **`crud-categorias`**

## Objetivo

Implementar o gerenciamento de categorias de produtos na área administrativa: listar, criar, editar e excluir.

## O que você deve construir

1. **Listagem**
   - Tabela com todas as categorias.
   - Ações editar / excluir por linha.

2. **Cadastro**
   - Formulário com campos: nome, slug e descrição.
   - Geração automática do slug a partir do nome.

3. **Edição**
   - Formulário pré-preenchido.
   - Atualização dos dados.

4. **Exclusão**
   - Confirmar antes de excluir.
   - Proteger categorias que possuem produtos (não excluir e avisar o usuário).

## Requisitos técnicos

- Rotas do grupo administrativo, protegidas por filtro `auth`:
  ```php
  $routes->group('admin/categorias', ['filter' => 'auth'], function ($routes) {
      $routes->get('/', 'Categorias::index');
      $routes->get('novo', 'Categorias::novo');
      $routes->post('salvar', 'Categorias::salvar');
      $routes->get('editar/(:num)', 'Categorias::editar/$1');
      $routes->post('atualizar/(:num)', 'Categorias::atualizar/$1');
      $routes->post('excluir/(:num)', 'Categorias::excluir/$1');
  });
  ```
- Controlador `app/Controllers/Admin/Categorias.php`.
- Modelo `app/Models/CategoriaModel.php`.
- Migração da tabela `categorias` (ver [04-banco-de-dados.md](04-banco-de-dados.md)).
- Visões em `app/Views/admin/categorias/` (index, form).
- Validação: `nome` e `slug` obrigatórios e únicos.
- Página de listagem com paginação (`$pager`) quando houver muitas categorias.

## Critérios de aceite

- [ ] É possível listar, criar, editar e excluir categorias.
- [ ] Slug é gerado automaticamente e é único.
- [ ] Não é possível excluir uma categoria com produtos vinculados.
- [ ] Mensagens de sucesso/erro aparecem após cada operação.
- [ ] Rotas administrativas exigem login.
- [ ] Dados persistidos no banco via migração.

## Dicas de implementação

1. Crie o modelo com `$allowedFields`, `$validation` e `$validationMessages`.
2. Para o slug, use o helper:
   ```php
   url_title($nome, '-', true)
   ```
3. Navegue entre telas com `redirect()->to(...)` e mensagens com `session()->setFlashdata(...)`.
4. Para impedir exclusão com produtos, verifique em `pedido`/`produtos` ou use FK com `RESTRICT` e trate a exceção de banco.
5. Use `html_escape()` ao exibir dados no formulário e na listagem.

## Referências

- Base: `docs/00-visao-geral.md`, `docs/02-estrutura-do-projeto.md`
- Banco: `docs/04-banco-de-dados.md`
- Autenticação (filtro `auth`): `docs/autenticacao.md`