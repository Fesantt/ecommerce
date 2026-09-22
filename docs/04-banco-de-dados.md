# Modelagem do banco de dados

Modelagem sugerida para o e-commerce. Ela pode ser ajustada conforme os módulos forem desenvolvidos, sempre usando **migrações**.

## Diagrama de entidades

```
usuarios 1 ──── N pedidos 1 ──── N pedido_itens N ──── 1 produtos
                                        │
categorias 1 ──── N produtos            └── relaciona com produtos
```

## Tabelas

### `usuarios`

| Campo          | Tipo         | Observações                     |
|----------------|--------------|---------------------------------|
| id             | INT (PK)     | auto increment                  |
| nome           | VARCHAR(120) |                                 |
| email          | VARCHAR(120) | único, usado no login           |
| senha          | VARCHAR(255) | hash (password_hash)            |
| perfil         | ENUM/VARCHAR | `admin` ou `cliente`            |
| created_at     | DATETIME     |                                 |
| updated_at     | DATETIME     |                                 |

### `categorias`

| Campo          | Tipo         | Observações                     |
|----------------|--------------|---------------------------------|
| id             | INT (PK)     | auto increment                  |
| nome           | VARCHAR(100) |                                 |
| slug           | VARCHAR(120) | único, usado nas URLs           |
| descricao      | TEXT         | opcional                        |
| created_at     | DATETIME     |                                 |
| updated_at     | DATETIME     |                                 |

### `produtos`

| Campo          | Tipo         | Observações                     |
|----------------|--------------|---------------------------------|
| id             | INT (PK)     | auto increment                  |
| categoria_id   | INT (FK)     | referência a `categorias.id`    |
| nome           | VARCHAR(150) |                                 |
| slug           | VARCHAR(160) | único, usado nas URLs           |
| descricao      | TEXT         |                                 |
| preco          | DECIMAL(10,2)| preço de venda                  |
| quantidade     | INT          | estoque disponível              |
| imagem         | VARCHAR(255) | opcional, caminho da imagem     |
| destaque       | TINYINT(1)   | flag para vitrine               |
| ativo          | TINYINT(1)   | controla exibição               |
| created_at     | DATETIME     |                                 |
| updated_at     | DATETIME     |                                 |

### `pedidos`

| Campo          | Tipo         | Observações                     |
|----------------|--------------|---------------------------------|
| id             | INT (PK)     | auto increment                  |
| usuario_id     | INT (FK)     | referência a `usuarios.id`      |
| numero         | VARCHAR(20)  | código legível do pedido        |
| status         | VARCHAR(20)  | `pendente`, `pago`, `cancelado` |
| total          | DECIMAL(10,2)| soma dos itens                  |
| created_at     | DATETIME     |                                 |
| updated_at     | DATETIME     |                                 |

### `pedido_itens`

| Campo          | Tipo         | Observações                     |
|----------------|--------------|---------------------------------|
| id             | INT (PK)     | auto increment                  |
| pedido_id      | INT (FK)     | referência a `pedidos.id`       |
| produto_id     | INT (FK)     | referência a `produtos.id`      |
| preco_unitario | DECIMAL(10,2)| preço no momento da compra      |
| quantidade     | INT          |                                 |
| subtotal       | DECIMAL(10,2)| preco * quantidade              |

## Relacionamentos

- `produtos.categoria_id` → `categorias.id` (N:1)
- `pedidos.usuario_id` → `usuarios.id` (N:1)
- `pedido_itens.pedido_id` → `pedidos.id` (N:1)
- `pedido_itens.produto_id` → `produtos.id` (N:1)

## Regras importantes

1. **Sempre** criar as tabelas com migrações (`php spark make:migration`).
2. Usar `utf8mb4`. Só para segurança: o `.env` define `default.charset = utf8mb4` via configuração do banco.
3. Chaves estrangeiras podem ser declaradas na migração com `onDelete` adequado (por exemplo, `CASCADE` para itens de pedido e `RESTRICT` para produto/categoria).
4. A senha nunca é armazenada em texto puro: sempre `password_hash()`.

## Migração inicial (referência)

Exemplo do comando:

```bash
php spark make:migration CreateUsuarios
php spark make:migration CreateCategorias
php spark make:migration CreateProdutos
php spark make:migration CreatePedidos
php spark make:migration CreatePedidoItens
```

Cada migração usa a API do `Forge` (por exemplo, `$this->forge->addField(...)`, `addKey`, `createTable`).