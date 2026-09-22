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

<h1><?= $categoria ? 'Editar categoria' : 'Nova categoria' ?></h1>

<?php if ($categoria): ?>
    <?= form_open('admin/categorias/atualizar/' . $categoria['id']) ?>
<?php else: ?>
    <?= form_open('admin/categorias/salvar') ?>
<?php endif; ?>

    <div class="form-grupo">
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" value="<?= esc(old('nome') ?? ($categoria['nome'] ?? '')) ?>" required>
    </div>

    <div class="form-grupo">
        <label for="descricao">Descricao</label>
        <textarea name="descricao" id="descricao" rows="4"><?= esc(old('descricao') ?? ($categoria['descricao'] ?? '')) ?></textarea>
    </div>

    <button type="submit" class="botao"><?= $categoria ? 'Salvar alteracoes' : 'Cadastrar' ?></button>
    <a class="botao botao-pequeno" href="<?= base_url('admin/categorias') ?>">Voltar</a>
<?= form_close() ?>

<?= $this->endSection() ?>