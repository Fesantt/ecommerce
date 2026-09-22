<nav class="nav-loja">
    <div class="container nav-loja-inner">
        <a href="<?= base_url('/') ?>">Todas as categorias</a>
        <?php foreach ($categorias as $categoria): ?>
            <a href="<?= base_url('categoria/' . $categoria['slug']) ?>"><?= esc($categoria['nome']) ?></a>
        <?php endforeach; ?>
    </div>
</nav>