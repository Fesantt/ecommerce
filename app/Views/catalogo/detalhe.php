<?= $this->extend('layouts/padrao') ?>

<?= $this->section('navLoja') ?>
<?= view('catalogo/_nav_loja', ['categorias' => $categorias]) ?>
<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>

<div class="produto-detalhe">
    <div class="produto-foto">
        <?php if ($produto['imagem']): ?>
            <img src="<?= base_url('uploads/' . $produto['imagem']) ?>" alt="<?= esc($produto['nome']) ?>" class="produto-foto">
        <?php else: ?>
            <span>Sem imagem</span>
        <?php endif; ?>
    </div>

    <div class="produto-info">
        <h1><?= esc($produto['nome']) ?></h1>
        <p class="card-preco">R$ <?= number_format((float) $produto['preco'], 2, ',', '.') ?></p>

        <?php if ((int) $produto['quantidade'] === 0): ?>
            <p><span class="badge badge-vermelho">Esgotado</span></p>
        <?php else: ?>
            <p><span class="badge badge-verde">Em estoque: <?= $produto['quantidade'] ?></span></p>
        <?php endif; ?>

        <?php if (! empty($produto['descricao'])): ?>
            <p><?= esc($produto['descricao']) ?></p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>