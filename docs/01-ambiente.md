# Preparação do ambiente

Guia passo a passo para rodar a base do projeto na sua máquina.

## 1. Pré-requisitos

- PHP 8.1+ com as extensões: `intl`, `mbstring`, `mysqli`, `curl` (e `zip`, `gd` quando forem usadas imagens/upload);
- Composer 2.x;
- MySQL 5.7+ ou MariaDB;
- Git.

Verifique a instalação:

```bash
php -v
composer --version
git --version
```

## 2. Instalar as dependências

Na raiz do projeto:

```bash
composer install
```

## 3. Configurar o arquivo de ambiente

O arquivo `.env` não vai para o repositório (contém credenciais). Copie o modelo fornecido:

```bash
cp env .env
```

Edite o `.env` e ajuste, no mínimo:

```ini
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080'
database.default.hostname = localhost
database.default.database = ecommerce
database.default.username = root
database.default.password = SUA_SENHA
database.default.DBDriver = MySQLi
database.default.port = 3306
```

> Em `CI_ENVIRONMENT = production` as mensagens de erro detalhadas são ocultadas.

## 4. Criar o banco de dados

Acesse o MySQL e crie o banco usado na configuração:

```sql
CREATE DATABASE ecommerce CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

## 5. Rodar o servidor de desenvolvimento

```bash
php spark serve
```

Acesse <http://localhost:8080>. Você deve ver a página inicial (mensagem de boas-vindas do CodeIgniter 4).

## 6. Verificar rotas e serviços

```bash
php spark routes
php spark db:status
```

## Solução de problemas

| Problema | Causa provável | Solução |
|----------|----------------|---------|
| Tela branca em produção | `CI_ENVIRONMENT = production` | Defina `development` |
| Erro de conexão com o banco | credenciais incorretas no `.env` | Confira `database.default.*` |
| Porta 8080 ocupada | outro processo no ar | `php spark serve --port 8081` |
| Página não carrega CSS | `app.baseURL` errado | Ajuste `app.baseURL` no `.env` |

## Próximos passos

- Entenda a estrutura do projeto em [02-estrutura-do-projeto.md](02-estrutura-do-projeto.md).
- Veja o fluxo de trabalho com Git em [03-git-e-branches.md](03-git-e-branches.md).