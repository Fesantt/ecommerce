<?= $this->extend('layouts/padrao') ?>

<?= $this->section('conteudo') ?>

<?= $menuAdmin ?>

<?php $erros = session()->getFlashdata('erros') ?? []; ?>

<?php if (! empty($erros)): ?>
    <div class="aviso aviso-erro">
        <ul>
            <?php foreach ($erros as $erro): ?>
                <li><?= esc($erro) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<h1><?= $produto ? 'Editar produto' : 'Novo produto' ?></h1>

<?php if ($produto): ?>
    <?= form_open_multipart('admin/produtos/atualizar/' . $produto['id']) ?>
<?php else: ?>
    <?= form_open_multipart('admin/produtos/salvar') ?>
<?php endif; ?>

    <div class="form-grupo">
        <label for="categoria_id">Categoria</label>
        <select name="categoria_id" id="categoria_id" required>
            <option value="">Selecione...</option>
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?= $categoria['id'] ?>" <?= old('categoria_id') == $categoria['id'] || (! empty($produto) && (int) $produto['categoria_id'] === (int) $categoria['id']) ? 'selected' : '' ?>>
                    <?= esc($categoria['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-grupo">
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" value="<?= esc(old('nome') ?? ($produto['nome'] ?? '')) ?>" required>
    </div>

    <div class="form-grupo">
        <label for="descricao">Descricao</label>
        <textarea name="descricao" id="descricao" rows="4"><?= esc(old('descricao') ?? ($produto['descricao'] ?? '')) ?></textarea>
    </div>

    <div class="form-linha">
        <div class="form-grupo">
            <label for="preco">Preco (R$)</label>
            <input type="number" name="preco" id="preco" step="0.01" min="0.01" value="<?= esc(old('preco') ?? (! empty($produto) ? number_format((float) $produto['preco'], 2, '.', '') : '')) ?>" required>
        </div>

        <div class="form-grupo">
            <label for="quantidade">Quantidade em estoque</label>
            <input type="number" name="quantidade" id="quantidade" min="0" value="<?= esc(old('quantidade') ?? ($produto['quantidade'] ?? 0)) ?>" required>
        </div>
    </div>

    <div class="form-grupo">
        <label for="imagem">Imagem</label>
        <?php if (! empty($produto['imagem'])): ?>
            <p><img src="<?= base_url('uploads/' . $produto['imagem']) ?>" alt="<?= esc($produto['nome']) ?>" class="thumb"></p>
        <?php endif; ?>
        <input type="file" name="imagem" id="imagem" accept="image/*">
    </div>

    <div class="form-grupo form-checa">
        <label>
            <input type="checkbox" name="destaque" value="1" <?= old('destaque') || (! empty($produto) && (int) $produto['destaque'] === 1) ? 'checked' : '' ?>>
            Em destaque na vitrine
        </label>
    </div>

    <div class="form-grupo form-checa">
        <label>
            <input type="checkbox" name="ativo" value="1" <?= old('ativo') || empty($produto) || (int) ($produto['ativo'] ?? 1) === 1 ? 'checked' : '' ?>>
            Produto ativo na loja
        </label>
    </div>

    <button type="submit" class="botao"><?= $produto ? 'Salvar alteracoes' : 'Cadastrar' ?></button>
    <a class="botao botao-pequeno" href="<?= base_url('admin/produtos') ?>">Voltar</a>
<?= form_close() ?>

<?= $this->endSection() ?>