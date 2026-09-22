# Loja Virtual — Projeto do Curso

Aplicação base construída com **CodeIgniter 4** para desenvolvimento de um **e-commerce simples** ao longo do curso.

O código-fonte da base **não contém comentários**: toda a orientação está documentada nos arquivos `markdown` (`.md`).

## Visão geral

O projeto entrega apenas a estrutura base do CodeIgniter 4 (instalação limpa, sem regras de negócio). A partir daqui, cada módulo do e-commerce é desenvolvido pelos alunos através de **branches de estudo**, cada uma com sua documentação de tarefa.

## Requisitos

| Ferramenta | Versão                          |
|------------|---------------------------------|
| PHP        | 8.1 ou superior (recomendado 8.4) |
| Composer   | 2.x                             |
| Banco de dados | MySQL 5.7+ / MariaDB          |
| Git        | 2.x                             |

## Configuração rápida

```bash
# 1. Instalar dependências
composer install

# 2. Preparar a configuração de ambiente
cp env .env
# editar .env e ajustar acesso ao banco (database.default.*)

# 3. Criar o banco de dados 'ecommerce' no MySQL

# 4. Subir o servidor de desenvolvimento
php spark serve
```

Acesse <http://localhost:8080>.

> Consulte [docs/01-ambiente.md](docs/01-ambiente.md) para o passo a passo completo.

## Estrutura de branches

| Branch              | Módulo                                              | Documentação |
|---------------------|-----------------------------------------------------|--------------|
| `base`              | Instalação base do CodeIgniter 4 (padrão)           | `docs/`      |
| `autenticacao`      | Cadastro, login, logout e recuperação de senha      | [docs/autenticacao.md](docs/autenticacao.md) |
| `crud-categorias`   | CRUD de categorias                                  | [docs/crud-categorias.md](docs/crud-categorias.md) |
| `crud-produtos`     | CRUD de produtos                                    | [docs/crud-produtos.md](docs/crud-produtos.md) |
| `carrinho`          | Carrinho de compras                                 | [docs/carrinho.md](docs/carrinho.md) |
| `checkout`          | Finalização de compra e pedidos                     | [docs/checkout.md](docs/checkout.md) |

Cada branch parte da base e contém apenas a **tarefa documentada**: o código do módulo é desenvolvido pelo aluno.

## Documentação

| Arquivo  | Conteúdo |
|----------|----------|
| [docs/00-visao-geral.md](docs/00-visao-geral.md) | Visão geral e escopo do e-commerce |
| [docs/01-ambiente.md](docs/01-ambiente.md)       | Preparação do ambiente de desenvolvimento |
| [docs/02-estrutura-do-projeto.md](docs/02-estrutura-do-projeto.md) | Como o CodeIgniter 4 está organizado |
| [docs/03-git-e-branches.md](docs/03-git-e-branches.md) | Fluxo de trabalho com Git e branches |
| [docs/04-banco-de-dados.md](docs/04-banco-de-dados.md) | Sugestão de modelagem do banco de dados |

## Comandos úteis

```bash
php spark serve                 # servidor de desenvolvimento
php spark routes                # listar rotas cadastradas
php spark make:controller Nome  # gerar controlador
php spark make:model Nome       # gerar modelo
php spark make:migration Nome   # gerar migração
php spark migrate               # executar migrações
```

## Licença

Este projeto é uma adaptação do [appstarter](https://github.com/codeigniter4/appstarter) do CodeIgniter 4, sob a licença MIT (veja o arquivo `LICENSE`).