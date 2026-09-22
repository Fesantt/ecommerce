# Tarefa: Busca de produtos

Branch de estudo: **`busca-produtos`**

## Objetivo

Adicionar busca por texto na vitrine, permitindo encontrar produtos por nome ou descrição, com filtro por categoria.

## O que você deve construir

1. **Campo de busca**
   - Input no layout compartilhado (header) que leva para `/busca?q=termo`.
   - Resultados na rota `GET /busca`.

2. **Resultados**
   - Listar produtos ativos cujo nome ou descrição contenham o termo.
   - Busca insensível a maiúsculas/minúsculas e a acentos (opcional).
   - Com termo vazio, listar todos os produtos (como a vitrine).

3. **Filtro por categoria**
   - Combo (select) com as categorias para restringir a busca.
   - Combinação: `q` + `categoria` ao mesmo tempo.

4. **Paginação com os filtros preservados**
   - Ao trocar de página, `q` e `categoria` continuam nos links (`$pager->links()` com query strings).

## Requisitos técnicos

- Rota `GET /busca` no `Catalogo` (ou controlador próprio, `Busca` se preferir).
- Consulta usando `LIKE`:
  ```php
  $builder->groupStart()
      ->like('nome', $termo)
      ->orLike('descricao', $termo)
  ->groupEnd();
  ```
- Filtro de categoria aplicado somente quando vier válida (e existir).
- Termo limpo com `html_escape()` na exibição e `urlencode()` nos links.
- Mensagem "nenhum resultado encontrado" quando vazio.

## Critérios de aceite

- [ ] Busca encontra produtos pelo nome e pela descrição.
- [ ] Resultado é sempre de produtos ativos.
- [ ] Filtro por categoria funciona junto com o termo de busca.
- [ ] Paginação mantém os filtros na próxima página.
- [ ] Sem resultados, exibe mensagem amigável.
- [ ] Termo digitado continua preenchido no campo após a busca.

## Dicas de implementação

1. Para paginação com query string:
   ```php
   $pager->links() ? $pager->links() : ''
   ```
   basta que o `paginate()` use `query()` para capturar `q`/`categoria`:
   ```php
   $this->request->getGet('q');
   ```
2. Considere `LIKE` simples; para acentos, dependendo do servidor use `BINARY`/coleção especial do MySQL (tema avançado).
3. No layout, o form de busca usa `method="get"` com input `name="q"` e select `name="categoria"`.
4. Ao montar os links de paginação, garanta que `$pager` foi instanciado com `only(['q', 'categoria'])`.

## Referências

- Catálogo público: `docs/catalogo.md`
- Banco: `docs/04-banco-de-dados.md`
- Base: `docs/02-estrutura-do-projeto.md`