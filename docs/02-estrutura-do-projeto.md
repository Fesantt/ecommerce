# Estrutura do projeto

## Visão geral da pasta `app`

O código da aplicação vive dentro de `app/`, organizado no padrão MVC.

```
app/
├── Config/              Configurações (banco, rotas, filtros, etc.)
├── Controllers/         Recebem a requisição e orquestram o fluxo
├── Database/
│   ├── Migrations/      Migrações do banco (criação de tabelas)
│   └── Seeds/           Dados iniciais (opcional)
├── Filters/             Sem restrições: filtros HTTP (ex.: exigir login)
├── Helpers/             Funções auxiliares globais
├── Language/            Arquivos de tradução/validação
├── Libraries/           Classes utilitárias
├── Models/              Acesso e regras de dados com o banco
├── Views/               Telas (HTML com PHP embutido)
└── View/                Layouts e células de interface
```

Outras pastas da raiz:

| Pasta/Arquivo      | Função                                                        |
|--------------------|---------------------------------------------------------------|
| `public/`          | Raiz pública do servidor (CSS, JS, imagens, `index.php`)      |
| `writable/`        | Arquivos graváveis: cache, logs, sessões, uploads             |
| `tests/`           | Testes automatizados                                          |
| `vendor/`          | Dependências do Composer (não versionado)                     |
| `env`              | Modelo de configuração de ambiente                            |
| `spark`            | Ferramenta de linha de comando do CI4                         |

## Ciclo de uma requisição

```
Navegador → public/index.php → Rota (app/Config/Routes.php)
        → Controller (app/Controllers) → Model (app/Models)
        → View (app/Views) → HTML de volta ao navegador
```

1. Toda requisição passa pelo `public/index.php`.
2. As rotas (`Routes.php`) decidem qual `Controller` responde.
3. O `Controller` usa `Models` para ler/gravar dados.
4. O `Controller` devolve uma `View` renderizada.

## Arquivos importantes na base

| Arquivo                          | Para que serve                              |
|----------------------------------|---------------------------------------------|
| `app/Config/Routes.php`          | Definição das rotas (`$routes->get(...)`)    |
| `app/Config/App.php`             | Configurações gerais (`baseURL`, timezone)   |
| `app/Config/Database.php`        | Configuração de conexões com o banco         |
| `app/Config/Migrations.php`      | Configuração do sistema de migrações         |
| `app/Config/Filters.php`         | Registro de filtros (p. ex. `auth`)          |
| `app/Config/Session.php`         | Configuração de sessão                       |
| `app/Controllers/Home.php`       | Controlador inicial da página principal      |
| `app/Models/`                    | Modelos (vazio na base)                      |

## Convenções

- **Controller**: `Nome` em `app/Controllers/Nome.php` (classe estendendo `BaseController`).
- **Model**: `NomeModel` em `app/Models/NomeModel.php` (estendendo `Model`).
- **View**: arquivos em `app/Views`, nomeados com letras minúsculas e `_` entre palavras.
- **Rota**: método público do controller mapeado em `Routes.php`.
- **Migração**: arquivos em `app/Database/Migrations`, nomeados com padrão de data.

## Comandos uteis do `spark`

```bash
php spark routes                    # lista as rotas
php spark make:controller Nome
php spark make:model NomeModel
php spark make:migration Nome
php spark make:seeder NomeSeeder
php spark migrate
php spark db:seed NomeSeeder
php spark serve
```

Próximo: [03-git-e-branches.md](03-git-e-branches.md).