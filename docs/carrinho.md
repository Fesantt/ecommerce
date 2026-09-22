# Tarefa: Carrinho de compras

Branch de estudo: **`carrinho`**

## Objetivo

Implementar o carrinho de compras: adicionar, alterar quantidade, remover e calcular o total.

## O que você deve construir

1. **Adicionar ao carrinho**
   - Botão "adicionar ao carrinho" na vitrine e no detalhe do produto.
   - Funciona sem login (dados guardados na sessão).
2. **Página do carrinho**
   - Lista dos itens com imagem, nome, preço unitário, quantidade e subtotal.
   - Campos para alterar quantidade e botão remover.
   - Total geral da compra.
3. **Persistência na sessão**
   - Carrinho permanece entre páginas.
   - Ao adicionar o mesmo produto, a quantidade é somada.
4. **Validações**
   - Não permitir quantidade maior que o estoque do produto.
   - Não permitir adicionar produto inativo.

## Requisitos técnicos

- Rota pública `/carrinho` (get) e rotas para `adicionar`, `atualizar` e `remover` (post).
- Controlador `app/Controllers/Carrinho.php`.
- Auxiliar (helper ou service) para manipular o carrinho armazenado na sessão.
- Visões em `app/Views/carrinho/`.
- Totais calculados em código, nunca confiando em valores de formulário (recalcule a partir do banco).

## Critérios de aceite

- [ ] Adicionar produto ao carrinho sem login funciona.
- [ ] Quantidade é atualizada e atinge o total corretamente.
- [ ] É possível remover um item e o total é recalculado.
- [ ] Quantidade respeita o estoque do produto.
- [ ] Produto inativo não pode ser adicionado.

## Dicas de implementação

1. Guarde o carrinho na sessão como array, por exemplo:
   ```php
   [
       'produto_id' => ['produto_id' => 1, 'quantidade' => 2, 'preco' => 19.90],
       ...
   ]
   ```
2. Crie uma classe `app/Libraries/Carrinho.php` (ou service) com métodos `adicionar()`, `atualizar()`, `remover()`, `itens()`, `total()`.
3. Ao montar a página do carrinho, sempre busque o produto fresco no banco (`idade do preço`).
4. Recalcule o total no servidor; não confie no valor enviado pelo formulário.
5. Exiba um aviso quando o carrinho estiver vazio.

## Referências

- Base: `docs/00-visao-geral.md`, `docs/02-estrutura-do-projeto.md`
- Produtos e catálogo: `docs/crud-produtos.md`
- Próximo módulo (fechamento): `docs/checkout.md`