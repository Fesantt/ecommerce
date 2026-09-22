# Tarefa: Dashboard administrativo

Branch de estudo: **`dashboard-admin`**

## Objetivo

Construir um painel inicial para o administrador, com resumo dos dados da loja.

## O que você deve construir

1. **Cards de resumo**
   - Total de produtos cadastrados.
   - Total de categorias.
   - Total de pedidos.
   - Faturamento (soma dos `total` dos pedidos pagos).

2. **Pedidos pendentes**
   - Contagem de pedidos com status `pendente`.
   - Aviso visual quando houver pedidos aguardando.

3. **Mais vendidos**
   - Lista dos produtos mais vendidos (top 5) com quantidade vendida.
   - Consulta agrupando `pedido_itens`.

4. **Estoque baixo**
   - Lista de produtos com `quantidade` abaixo de um limite (ex.: 5).

## Requisitos técnicos

- Rota protegida por `auth`:
  ```php
  $routes->get('/admin', 'Admin\Dashboard::index', ['filter' => 'auth']);
  ```
- Controlador `app/Controllers/Admin/Dashboard.php`.
- Consultas agregadas com o Query Builder:
  - `countAll()` para produtos/categorias/pedidos.
  - `selectSum('total')` filtrado por status `pago`.
  - `select('produto_id')->selectSum('quantidade')...groupBy('produto_id')` para mais vendidos.
  - `where('quantidade <=', 5)` para estoque baixo.
- Visão `app/Views/admin/dashboard.php`.
- Ajuste de permissão: idealmente só `admin` acessa (ver filtro/perfil).

## Critérios de aceite

- [ ] Painel mostra os 4 cards com valores corretos.
- [ ] Faturamento considera somente pedidos `pago`.
- [ ] Top 5 mais vendidos aparece ordenado por quantidade.
- [ ] Estoque baixo lista produtos abaixo do limite definido.
- [ ] Painel exige login.
- [ ] Dados são sempre lidos do banco (sem valores fixos).

## Dicas de implementação

1. Use múltiplas consultas simples no controller e passe arrays para a view.
2. Para o Query Builder:
   ```php
   $this->produtoModel->select('produtos.id, produtos.nome, SUM(pedido_item.quantidade) AS total_vendido')
       ->join('pedido_item', 'pedido_item.produto_id = produtos.id')
       ->groupBy('produtos.id')
       ->orderBy('total_vendido', 'DESC')
       ->limit(5)
       ->findAll();
   ```
3. Formate preços no card de faturamento.
4. Se quiser um filtro de período (ex.: últimos 30 dias), use `where('pedidos.created_at >=', date(...))`.
5. Adicione um `Dashboard::index` como rota raiz do grupo `admin` (`/admin`).

## Referências

- Gestão de pedidos: `docs/admin-pedidos.md`
- Gestão de usuários: `docs/admin-usuarios.md`
- Banco: `docs/04-banco-de-dados.md`
- Autenticação (filtro `auth`): `docs/autenticacao.md`