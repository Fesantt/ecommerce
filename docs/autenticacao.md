# Tarefa: Autenticação

Branch de estudo: **`autenticacao`**

## Objetivo

Implementar o sistema de autenticação do e-commerce: cadastro de usuários, login, logout e troca de senha, com sessão.

## O que você deve construir

1. **Cadastro de usuário**
   - Formulário público: nome, email e senha.
   - Validação dos dados (email válido e único).
   - Senha armazenada com hash (`password_hash`).
   - Após cadastrar, o usuário é autenticado e redirecionado.

2. **Login**
   - Formulário de email + senha.
   - Validação das credenciais.
   - Registro do usuário na sessão.

3. **Logout**
   - Destruir os dados de sessão.
   - Redirecionar para a página inicial.

4. **Troca de senha**
   - Apenas para usuário logado.
   - Exigir senha atual + nova senha.
   - Nova senha com confirmação.

## Requisitos técnicos

- Rota para cada ação (`get`/`post`), definida em `app/Config/Routes.php`.
- Controlador, por exemplo, `app/Controllers/Auth.php` (ou separados por recurso).
- Modelo `app/Models/UsuarioModel.php` com regras de validação.
- Tabela `usuarios` criada via **migração** (ver [04-banco-de-dados.md](04-banco-de-dados.md)).
- Visões em `app/Views/auth/` (cadastro, login, troca de senha).
- Campos obrigatórios com `required`, email com `valid_email`/`is_unique`.
- Bloquear o acesso a áreas logadas usando **filtro** (ex.: `auth`) registrado em `app/Config/Filters.php`.

## Critérios de aceite

- [ ] É possível cadastrar um usuário e ele já entra logado.
- [ ] Login com credenciais incorretas exibe mensagem de erro.
- [ ] Sessão limpa ao fazer logout (voltar com o botão do navegador não mantém acesso).
- [ ] Usuário não logado é redirecionado ao acessar uma rota protegida.
- [ ] Senha nunca aparece em texto puro no banco.
- [ ] Validações em português nas mensagens de erro.

## Dicas de implementação

1. Estruture primeiro com um `AuthController` único com métodos `cadastro()`, `login()`, `logout()` e `trocarSenha()`.
2. Use a classe `session()` para guardar `usuario_id` e `perfil`.
3. Para proteger rotas, crie um filtro `auth` em `app/Filters/` e o registre:
   ```php
   public $aliases = [
       'auth' => \App\Filters\AuthFilter::class,
   ];
   ```
   ```php
   $routes->get('/admin', 'Admin::index', ['filter' => 'auth']);
   ```
4. Compare senhas com `password_verify()`.
5. Use o helper `form_validation` (`validation_service`) ou a validação do próprio Model.

## Referências

- Documentação base: `docs/00-visao-geral.md`, `docs/02-estrutura-do-projeto.md`, `docs/03-git-e-branches.md`
- Modelagem: `docs/04-banco-de-dados.md`
- Fluxo de trabalho Git: `docs/03-git-e-branches.md`