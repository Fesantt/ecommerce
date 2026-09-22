# Tarefa: CRUD de Produtos

Branch de estudo: **`crud-produtos`**

## Objetivo

Implementar o gerenciamento de produtos na área administrativa.

## O que você deve construir

1. **Listagem** de produtos com busca por nome e filtro por categoria.
2. **Cadastro** com campos: nome, slug, categoria, descrição, preço, quantidade (estoque), imagem, destaque e ativo.
3. **Edição** dos dados do produto.
4. **Exclusão** com confirmação.

> A exibição pública dos produtos (vitrine, detalhe e listagem por categoria) é uma tarefa separada: veja `docs/catalogo.md`.

## Requisitos técnicos

- Rotas administrativas protegidas (`auth`).
- Controlador `app/Controllers/Admin/Produtos.php`.
- Modelo `app/Models/ProdutoModel.php` com joins para categoria.
- Migração da tabela `produtos` (ver [04-banco-de-dados.md](04-banco-de-dados.md)).
- Upload de imagem com validação de tipo e tamanho (guarde em `writable/uploads` ou `public/uploads`).
- Validação: `nome` único, `preco` numérico positivo, `quantidade` inteiro >= 0, `categoria_id` existente.
- Preço exibido no formato brasileiro, ex.: `R$ 1.234,56`.

## Critérios de aceite

- [ ] Admin consegue criar, editar e excluir produtos.
- [ ] Ao criar/editar, o slug é gerado e é único.
- [ ] Existe busca/filtro na listagem administrativa.
- [ ] Imagem validada e salva corretamente.
- [ ] Preço formatado em todos os lugares.

## Dicas de implementação

1. Use o helper `url_title()` para o slug e o helper `number_to_currency()` ou a função `@` formatador para preço.
2. No modelo, configure relacionamento com `builder()->join(...)` para trazer o nome da categoria.
3. Para o upload:
   ```php
   $imagem = $this->request->getFile('imagem');
   if ($imagem && $imagem->isValid()) {
       $novoNome = $imagem->getRandomName();
       $imagem->move(WRITEPATH . 'uploads', $novoNome);
   }
   ```
4. Para vitrine e listagens grandes use paginação com `paginate()`.
5. Sempre exiba com `html_escape()`.

## Referências

- Base: `docs/00-visao-geral.md`, `docs/02-estrutura-do-projeto.md`
- Banco: `docs/04-banco-de-dados.md`
- Categorias: `docs/crud-categorias.md`
- Catálogo público: `docs/catalogo.md`
- Autenticação (filtro `auth`): `docs/autenticacao.md`