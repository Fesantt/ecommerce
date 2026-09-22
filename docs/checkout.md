# Tarefa: Checkout e pedidos

Branch de estudo: **`checkout`**

## Objetivo

Finalizar a compra: o usuário logado confirma o carrinho, o pedido é registrado no banco e o estoque é atualizado.

## O que você deve construir

1. **Página de checkout**
   - Resumo do carrinho (itens e total).
   - Exige usuário logado (filtro `auth`); visitante é redirecionado para o login.
   - Botão "Confirmar pedido".

2. **Confirmação do pedido**
   - Criar o `pedido` com status `pendente`, número único e total.
   - Criar os `pedido_itens` com preço e quantidade de cada produto.
   - Atualizar o estoque dos produtos (reduzir `quantidade`).
   - Limpar o carrinho da sessão.
   - Exibir tela de sucesso com o número do pedido.

3. **Meus pedidos**
   - Lista dos pedidos do usuário logado (`/meus-pedidos`).
   - Detalhe de um pedido com seus itens.

4. **Integridade**
   - Estoque insuficiente cancela a operação com mensagem clara.
   - Transação: ou o pedido completo é gravado, ou nada.

## Requisitos técnicos

- Rotas:
  - `GET /checkout` e `POST /checkout/confirmar`, protegidas por `auth`.
  - `GET /meus-pedidos` e `GET /meus-pedidos/(:num)` protegidas por `auth`.
- Controlador `app/Controllers/Checkout.php` (e `Pedidos.php` para listagem, se preferir).
- Modelos `PedidoModel` e `PedidoItemModel`.
- Migrações das tabelas `pedidos` e `pedido_itens` (ver [04-banco-de-dados.md](04-banco-de-dados.md)).
- Uso de transação de banco:
  ```php
  $db = db_connect();
  $db->transBegin();
  // insert pedido, insert itens, atualizar estoque
  if ($db->transStatus() === false) {
      $db->transRollback();
  } else {
      $db->transCommit();
  }
  ```

## Critérios de aceite

- [ ] Visitante não consegue acessar `/checkout` (é mandado ao login).
- [ ] Confirmar o pedido cria pedido + itens e limpa o carrinho.
- [ ] Estoque é reduzido corretamente após a compra.
- [ ] Estoque insuficiente impede a compra com mensagem clara.
- [ ] `Meus pedidos` mostra somente os pedidos do usuário logado.
- [ ] O número do pedido é único.

## Dicas de implementação

1. Gere o número do pedido, por exemplo: `PED-` + ano + id, ou `uniqid()` com prefixo.
2. Recupere o carrinho e valide cada item contra o banco antes de gravar (sem confiar no valor do formulário).
3. Calcule o `subtotal` por item e o `total` no servidor.
4. Após confirmar, limpe a sessão do carrinho e redirecione para a tela de sucesso com `setFlashdata`.
5. Ao listar pedidos do usuário, filtre por `usuario_id` da sessão.

## Referências

- Base: `docs/00-visao-geral.md`, `docs/02-estrutura-do-projeto.md`
- Banco: `docs/04-banco-de-dados.md`
- Carrinho: `docs/carrinho.md`
- Autenticação: `docs/autenticacao.md`