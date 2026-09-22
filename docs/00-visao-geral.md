# Visão geral do e-commerce

## Propósito

Desenvolver um **e-commerce simples** para venda de produtos em uma loja virtual. O projeto final deve permitir:

- navegar pelo catálogo de produtos por categoria;
- visualizar os detalhes de um produto;
- adicionar produtos ao carrinho;
- finalizar a compra (pedido vinculado ao usuário logado);
- gerenciar produtos, categorias e usuários (área administrativa simples).

## Escopo por módulo

| Módulo                  | Descrição resumida                                           |
|-------------------------|--------------------------------------------------------------|
| Catálogo                | Listagem e detalhe de produtos públicos                      |
| Busca de produtos       | Busca por texto e filtro de categoria na vitrine             |
| Categorias              | Agrupamento de produtos                                      |
| Autenticação            | Cadastro, login, logout e troca de senha                     |
| Perfil do usuário       | Edição dos próprios dados                                    |
| Carrinho                | Itens selecionados, quantidades e total                       |
| Checkout                | Confirmação do pedido e registro de pedidos                  |
| Produtos (admin)        | Cadastro, edição, exclusão e listagem de produtos            |
| Usuários (admin)        | Gestão de contas e perfis de acesso                          |
| Pedidos (admin)         | Acompanhamento e atualização de status dos pedidos           |
| Dashboard (admin)       | Resumo de vendas, estoque e pedidos                          |

## Requisitos funcionais (visão geral)

1. O visitante visualiza produtos, categorias e busca sem estar logado.
2. Para fechar um pedido, o usuário deve estar logado.
3. Um usuário administrador gerencia produtos, categorias, usuários e pedidos.
4. O carrinho é mantido por usuário (na sessão).
5. O usuário logado gerencia o próprio perfil e acompanha seus pedidos.

## Requisitos não funcionais

- Código sem comentários; orientações apenas via documentação em `docs/`.
- Seguir o padrão **MVC** do CodeIgniter 4 (rotas, controladores, modelos e visões).
- Utilizar **migrações** para criar/alterar o banco de dados.
- Utilizar **validação** nas entradas de formulários (server-side).

## Modelagem sugerida

O banco de dados proposto está documentado em [04-banco-de-dados.md](04-banco-de-dados.md).

## Regras de avaliação

Cada branch de estudo define seus próprios critérios de aceite. Antes de começar, leia a documentação da branch e o item [03-git-e-branches.md](03-git-e-branches.md).