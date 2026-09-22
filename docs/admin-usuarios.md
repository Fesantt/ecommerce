# Tarefa: Gestão de usuários (admin)

Branch de estudo: **`admin-usuarios`**

## Objetivo

Permitir que um administrador gerencie os usuários cadastrados: listar, criar, editar e ativar/desativar contas.

## O que você deve construir

1. **Listagem**
   - Tabela de usuários com nome, email, perfil e status.
   - Busca por nome/email e paginação.

2. **Cadastro de usuário (pelo admin)**
   - Formulário: nome, email, senha e perfil (`admin` ou `cliente`).

3. **Edição**
   - Alterar nome, email e perfil.
   - Senha opcional: só altera se for preenchida.

4. **Ativar / desativar**
   - Conta desativada não consegue logar (filtro `auth` verifica `ativo`).
   - Um admin **não pode** desativar a si mesmo.

## Requisitos técnicos

- Rotas em grupo administrativo protegido por `auth` (e idealmente por perfil `admin`):
  ```php
  $routes->group('admin/usuarios', ['filter' => 'auth'], function ($routes) {
      $routes->get('/', 'UsuarioAdmin::index');
      $routes->get('novo', 'UsuarioAdmin::novo');
      $routes->post('salvar', 'UsuarioAdmin::salvar');
      $routes->get('editar/(:num)', 'UsuarioAdmin::editar/$1');
      $routes->post('atualizar/(:num)', 'UsuarioAdmin::atualizar/$1');
      $routes->post('desativar/(:num)', 'UsuarioAdmin::desativar/$1');
      $routes->post('ativar/(:num)', 'UsuarioAdmin::ativar/$1');
  });
  ```
- Controlador `app/Controllers/Admin/Usuarios.php`.
- Modelo `UsuarioModel` (reaproveitado da autenticação) com regras de validação.
- Tabela `usuarios` com coluna `ativo` (ver [04-banco-de-dados.md](04-banco-de-dados.md)).
- Senha sempre com `password_hash()` ao cadastrar.

## Critérios de aceite

- [ ] Admin lista, busca e pagina usuários.
- [ ] Admin cria usuário com perfil definido por ele.
- [ ] Edição não apaga a senha quando o campo senha fica vazio.
- [ ] Usuário desativado não consegue fazer login.
- [ ] Admin não consegue desativar a própria conta.
- [ ] Mensagens de sucesso/erro após cada operação.

## Dicas de implementação

1. Para "senha opcional na edição": no `update`, só `set()` a senha se `senha` não estiver vazia.
2. No filtro `auth`, ao autenticar, verifique também o `ativo` do usuário.
3. Para não se auto-desativar, no controller compare o `id` da sessão com o `id` da rota e bloqueie.
4. Na listagem, não exiba a coluna de senha (nunca).
5. Use `redirect()->with('errors', validator_errors())` para devolver erros ao formulário.

## Referências

- Autenticação e filtro `auth`: `docs/autenticacao.md`
- Banco: `docs/04-banco-de-dados.md`
- Base: `docs/02-estrutura-do-projeto.md`