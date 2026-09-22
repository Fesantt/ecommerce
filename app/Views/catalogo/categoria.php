<?= $this->extend('layouts/padrao') ?>

<?= $this->section('navLoja') ?>
<?= view('catalogo/_nav_loja', ['categorias' => $categorias]) ?>
<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>

<?php if (empty($produtos)): ?>
    <p>Nenhum produto nesta categoria ainda.</p>
<?php else: ?>
    <h1><?= esc($categoria['nome']) ?></h1>
    <?php if (! empty($categoria['descricao'])): ?>
        <p><?= esc($categoria['descricao']) ?></p>
    <?php endif; ?>

    <div class="grade-produtos">
        <?php foreach ($produtos as $produto): ?>
            <?= view('catalogo/_card', ['produto' => $produto]) ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="paginacao"><?= $pager->links() ?></div>

<?= $this->endSection() ?>