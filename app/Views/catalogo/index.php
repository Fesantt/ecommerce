<?= $this->extend('layouts/padrao') ?>

<?= $this->section('navLoja') ?>
<?= view('catalogo/_nav_loja', ['categorias' => $categorias]) ?>
<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>

<h1>Loja Virtual</h1>

<?php if (empty($produtos)): ?>
    <p>Nenhum produto disponivel no momento.</p>
<?php else: ?>
    <div class="grade-produtos">
        <?php foreach ($produtos as $produto): ?>
            <?= view('catalogo/_card', ['produto' => $produto]) ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="paginacao"><?= $pager->links() ?></div>

<?= $this->endSection() ?>