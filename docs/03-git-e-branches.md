# Git e branches no curso

## Como o repositório está organizado

- A branch padrão é a **`base`**, com a instalação limpa do CodeIgniter 4.
- Cada módulo do curso mora em uma **branch própria**, criada a partir da `base`:

```
base  ← autenticacao
      ← crud-categorias
      ← crud-produtos
      ← carrinho
      ← checkout
```

Cada branch de estudo contém **somente a documentação da tarefa** (`docs/`). O código do módulo deve ser desenvolvido por você.

## Fluxo de trabalho recomendado

### 1. Baixar o repositório e entrar na branch da tarefa

```bash
git clone <url-do-repositorio>
cd ecommerce

git fetch origin
git checkout autenticacao
```

### 2. Criar sua branch de trabalho

Sempre trabalhe em uma branch separada, nunca na branch da tarefa diretamente:

```bash
git checkout -b aluno/seu-nome-autenticacao
```

### 3. Desenvolver em pequenos passos

```bash
git status                        # o que mudou
git add app/...                   # adiciona arquivos específicos
git commit -m "descrição curta do que foi feito"
```

Boas mensagens de commit (imperativo, curto):

```
git commit -m "adiciona tela de login"
git commit -m "cria tabela de usuarios via migracao"
```

### 4. Enviar para o repositório e abrir pull request

```bash
git push -u origin aluno/seu-nome-autenticacao
```

Em seguida, abra um **pull request (PR)** da sua branch de trabalho para a branch da tarefa (`autenticacao`). O professor revisa e comenta o código no PR.

## Regras de ouro

1. **Nunca** commitar em `main`/`base` diretamente.
2. **Nunca** versionar segredos: o `.env` já é ignorado pelo `.gitignore`.
3. Commitar apenas arquivos relevantes (não adicionar `vendor/`, `writable/`, `.env`).
4. Faça commits pequenos e com mensagens descritivas.
5. Não resolver conflito de forma destrutiva: peça ajuda ao professor.

## O que é esperado em uma entrega

- Branch de trabalho com nome do aluno.
- Pull request para a branch da tarefa.
- Código no padrão MVC do CI4, sem comentários.
- Migrações criadas pelo `spark`.
- Validação de formulários server-side.
- Testar o fluxo completo antes de entregar.

Próximo: [04-banco-de-dados.md](04-banco-de-dados.md).