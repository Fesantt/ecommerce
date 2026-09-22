# Loja Virtual — Projeto do Curso

Aplicação base construída com **CodeIgniter 4** para desenvolvimento de um **e-commerce simples** ao longo do curso.

O código-fonte da base **não contém comentários**: toda a orientação está documentada nos arquivos `markdown` (`.md`).

## Visão geral

O projeto entrega a estrutura base do CodeIgniter 4 (instalação limpa, sem regras de negócio) e, em cada **branch de estudo**, o módulo correspondente **já implementado** — servindo de referência/solução — além da documentação da tarefa. Os alunos reconstroem o módulo a partir da `base`. As branches seguem ordem de dependência:

```
base → autenticacao → crud-categorias → crud-produtos → catalogo
     → busca-produtos → carrinho → checkout → perfil-usuario
     → admin-usuarios → admin-pedidos → dashboard-admin
```

Cada branch contém todos os módulos anteriores (a aplicação é sempre funcional).

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

## Bancos de dados e dados iniciais

```bash
# aplicar as migracoes (cria todas as tabelas da base + modulo da branch)
php spark migrate

# opcional: dados de exemplo (admin@ecommerce.test / 123456)
php spark db:seed UsuarioSeeder
php spark db:seed CategoriaSeeder
php spark db:seed ProdutoSeeder
```

> Consulte [docs/01-ambiente.md](docs/01-ambiente.md) e [docs/04-banco-de-dados.md](docs/04-banco-de-dados.md).

## Estrutura de branches

| Branch              | Módulo                                              | Documentação |
|---------------------|-----------------------------------------------------|--------------|
| `base`              | Instalação base do CodeIgniter 4 (padrão)           | `docs/`      |
| `autenticacao`      | Cadastro, login, logout e recuperação de senha      | [docs/autenticacao.md](docs/autenticacao.md) |
| `crud-categorias`   | CRUD de categorias                                  | [docs/crud-categorias.md](docs/crud-categorias.md) |
| `crud-produtos`     | CRUD de produtos (admin)                            | [docs/crud-produtos.md](docs/crud-produtos.md) |
| `catalogo`          | Vitrine pública, detalhe e listagem por categoria   | [docs/catalogo.md](docs/catalogo.md) |
| `busca-produtos`    | Busca por texto e filtro de categoria               | [docs/busca-produtos.md](docs/busca-produtos.md) |
| `carrinho`          | Carrinho de compras                                 | [docs/carrinho.md](docs/carrinho.md) |
| `checkout`          | Finalização de compra e pedidos                     | [docs/checkout.md](docs/checkout.md) |
| `perfil-usuario`    | Meus dados e troca de senha                         | [docs/perfil-usuario.md](docs/perfil-usuario.md) |
| `admin-usuarios`    | Gestão de usuários (admin)                          | [docs/admin-usuarios.md](docs/admin-usuarios.md) |
| `admin-pedidos`     | Gestão de pedidos (admin)                           | [docs/admin-pedidos.md](docs/admin-pedidos.md) |
| `dashboard-admin`   | Painel administrativo com resumo da loja            | [docs/dashboard-admin.md](docs/dashboard-admin.md) |

Cada branch traz o módulo **implementado e funcional** (referência/solução) mais a documentação da tarefa em `docs/`. A `base` fica limpa, para os alunos reproduzirem o percurso.

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