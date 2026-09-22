# Tarefa: Catálogo público

Branch de estudo: **`catalogo`**

## Objetivo

Implementar a vitrine pública da loja: listagem de produtos, página de detalhe e listagem por categoria.

## O que você deve construir

1. **Vitrine (`/`)**
   - Listar produtos ativos (`ativo = 1`), com imagem, nome e preço.
   - Destaques primeiro (`destaque = 1`).
   - Paginação para listas longas.

2. **Detalhe (`/produto/:slug`)**
   - Página individual do produto: imagem grande, descrição, preço e estoque.
   - Botão "Adicionar ao carrinho".
   - Se o estoque for 0, mostrar "Esgotado" e desabilitar o botão.

3. **Por categoria (`/categoria/:slug`)**
   - Listar produtos ativos de uma categoria.
   - Mostrar o nome da categoria.
   - Tratar categoria inexistente (404 com mensagem amigável).

## Requisitos técnicos

- Rotas públicas:
  ```php
  $routes->get('/', 'Catalogo::index');
  $routes->get('produto/(:segment)', 'Catalogo::detalhe/$1');
  $routes->get('categoria/(:segment)', 'Catalogo::categoria/$1');
  ```
- Controlador `app/Controllers/Catalogo.php`.
- Consultas filtrarem sempre por `ativo = 1`.
- Visões em `app/Views/catalogo/` (index, detalhe, categoria).
- Layout padrão compartilhado para toda a loja (header com logo, busca e link do carrinho; footer).
- Preços formatados no padrão brasileiro.

## Critérios de aceite

- [ ] Vitrine mostra apenas produtos ativos.
- [ ] Produtos em destaque aparecem primeiro.
- [ ] Produto esgotado mostra "Esgotado" e não pode ser adicionado ao carrinho.
- [ ] URL de categoria e de produto usam slug.
- [ ] Categoria sem produto exibe mensagem (não quebra a página).
- [ ] Layout compartilhado em todas as páginas da loja.

## Dicas de implementação

1. Crie um layout base em `app/Views/layouts/` com `<?= $this->renderSection('conteudo') ?>` e seções para título/CSS.
2. Use `$catalogo->paginate(12)` e `$pager->links()` para paginação.
3. Para "destaque primeiro", ordene por `destaque DESC, created_at DESC`.
4. Só mostre o botão de carrinho se o produto estiver ativo e com estoque.
5. Consulte a categoria pelo slug com `first()` (+ `where('slug', $slug)`).

## Referências

- Base: `docs/00-visao-geral.md`, `docs/02-estrutura-do-projeto.md`
- Banco: `docs/04-banco-de-dados.md`
- Produtos (admin): `docs/crud-produtos.md`
- Busca na vitrine: `docs/busca-produtos.md`