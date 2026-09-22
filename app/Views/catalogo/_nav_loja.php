<nav class="nav-loja">
    <div class="container nav-loja-inner">
        <?= form_open('busca', ['method' => 'get', 'class' => 'busca-form nav-busca']) ?>
            <input type="text" name="q" value="<?= esc($busca ?? '') ?>" placeholder="Buscar produtos...">
            <select name="categoria">
                <option value="">Todas as categorias</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= $categoria['id'] ?>" <?= ($categoriaAtual ?? 0) === (int) $categoria['id'] ? 'selected' : '' ?>>
                        <?= esc($categoria['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="botao botao-pequeno">Buscar</button>
        <?= form_close() ?>

        <div class="nav-loja-links">
            <a href="<?= base_url('/') ?>">Inicio</a>
            <?php foreach ($categorias as $categoria): ?>
                <a href="<?= base_url('categoria/' . $categoria['slug']) ?>"><?= esc($categoria['nome']) ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</nav>