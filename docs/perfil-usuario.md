# Tarefa: Perfil do usuário

Branch de estudo: **`perfil-usuario`**

## Objetivo

Permitir que o usuário logado visualize e edite seus dados e troque a senha.

## O que você deve construir

1. **Ver dados**
   - Nome e email do usuário logado.

2. **Editar dados**
   - Alterar nome e email.
   - Email único, mas permitindo manter o próprio email atual (regra `is_unique` com exceção).

3. **Trocar senha**
   - Exigir a senha atual.
   - Nova senha com confirmação.
   - Validações: mínimo de caracteres, confirmação idêntica.

4. **Telas**
   - `GET /perfil` e `POST /perfil/atualizar`.
   - `GET /perfil/senha` e `POST /perfil/senha`.

## Requisitos técnicos

- Rotas protegidas por `auth`:
  ```php
  $routes->get('/perfil', 'Perfil::index');
  $routes->post('/perfil/atualizar', 'Perfil::atualizar');
  $routes->get('/perfil/senha', 'Perfil::senha');
  $routes->post('/perfil/senha/salvar', 'Perfil::salvarSenha');
  ```
- Controlador `app/Controllers/Perfil.php`.
- Modelo `UsuarioModel` reaproveitado.
- Validar `email` com `is_unique[usuarios.email,id,{id}]` para ignorar o próprio registro.
- Trocar senha validando a atual com `password_verify()` antes de gravar.

## Critérios de aceite

- [ ] Usuário vê e edita nome e email.
- [ ] Email duplicado (de outro usuário) é rejeitado.
- [ ] Usuário consegue manter o próprio email sem erro de "já utilizado".
- [ ] Troca de senha exige a senha atual correta.
- [ ] Nova senha exige confirmação e mínimo de 6 caracteres.
- [ ] Após salvar, mensagem de sucesso e dados atualizados na tela.

## Dicas de implementação

1. Na validação do email, use a regra com parâmetro de id:
   ```php
   'email' => 'required|valid_email|is_unique[usuarios.email,id,{id}]'
   ```
   e passe `id` do usuário logado no `setData()`.
2. Guarde o nome/email atualizados também na sessão (`$session->set(...)`) para o menu continuar mostrando dados novos.
3. Para a senha atual, busque o hash no banco e compare com `password_verify()`.
4. Se quiser reforço, use o validador `strong_password` do CodeIgniter.

## Referências

- Autenticação e sessão: `docs/autenticacao.md`
- Banco: `docs/04-banco-de-dados.md`
- Base: `docs/02-estrutura-do-projeto.md`