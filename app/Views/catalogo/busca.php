<?= $this->extend('layouts/padrao') ?>

<?= $this->section('navLoja') ?>
<?= view('catalogo/_nav_loja', ['categorias' => $categorias, 'busca' => $busca ?? '', 'categoriaAtual' => $categoriaAtual ?? 0]) ?>
<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>

<h1>Resultados da busca</h1>

<?php if ($busca !== ''): ?>
    <p>Termo buscado: <strong><?= esc($busca) ?></strong></p>
<?php endif; ?>

<?php if (empty($produtos)): ?>
    <p>Nenhum produto encontrado para a busca realizada.</p>
<?php else: ?>
    <div class="grade-produtos">
        <?php foreach ($produtos as $produto): ?>
            <?= view('catalogo/_card', ['produto' => $produto]) ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="paginacao"><?= $pager->links() ?></div>

<?= $this->endSection() ?>