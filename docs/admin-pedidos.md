# Tarefa: Gestão de pedidos (admin)

Branch de estudo: **`admin-pedidos`**

## Objetivo

Permitir que o administrador acompanhe e gerencie os pedidos realizados na loja.

## O que você deve construir

1. **Listagem de pedidos**
   - Tabela com número, cliente, total e status.
   - Filtro por status e busca pelo número do pedido.
   - Paginação.

2. **Detalhe do pedido**
   - Dados do cliente (nome, email).
   - Itens do pedido com preço, quantidade e subtotal.
   - Total e data de criação.
   - Status atual.

3. **Atualização de status**
   - Alterar status para, por exemplo: `pendente`, `pago`, `enviado`, `cancelado`.
   - Registrar o histórico de mudanças (opcional, via tabela ou log).

4. **Regras de status**
   - Pedido `cancelado` não volta a ser `pago`.
   - Cancelar pedido `pago` devolve o produto ao estoque (se ainda não enviado).

## Requisitos técnicos

- Rotas em grupo administrativo protegido:
  ```php
  $routes->group('admin/pedidos', ['filter' => 'auth'], function ($routes) {
      $routes->get('/', 'PedidoAdmin::index');
      $routes->get('detalhe/(:num)', 'PedidoAdmin::detalhe/$1');
      $routes->post('status/(:num)', 'PedidoAdmin::status/$1');
  });
  ```
- Controlador `app/Controllers/Admin/Pedidos.php`.
- Modelos `PedidoModel`, `PedidoItemModel` e `ProdutoModel` (joins para cliente e itens).
- Atualização de estoque dentro de **transação** quando houver cancelamento.
- Validação dos valores de status contra uma lista permitida (nunca aceitar status livre do formulário).

## Critérios de aceite

- [ ] Admin lista pedidos e filtra por status.
- [ ] Detalhe mostra cliente, itens e total.
- [ ] Status só aceita valores da lista permitida.
- [ ] Cancelar pedido pago devolve o estoque (transação).
- [ ] Um pedido não pode regredir de `pago`/`enviado` para `pendente`.

## Dicas de implementação

1. Defina as constantes de status no model, por exemplo:
   ```php
   public const STATUS = ['pendente', 'pago', 'enviado', 'cancelado'];
   ```
2. Ao cancelar um pedido `pago`, incremente `quantidade` de cada produto usando uma transação.
3. Para joins no detalhe, use `$pedidoModel->select(...)->join('usuario_itens', ...)` ou busque cada parte separadamente.
4. Mostre o status com um badge de cor diferente na listagem.
5. Nunca confie no valor do formulário: valide contra `STATUS`.

## Referências

- Checkout (criação do pedido): `docs/checkout.md`
- Banco: `docs/04-banco-de-dados.md`
- Base: `docs/02-estrutura-do-projeto.md`