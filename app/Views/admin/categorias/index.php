<?= $this->extend('layouts/padrao') ?>

<?= $this->section('conteudo') ?>

<?= $menuAdmin ?>

<div class="cabecalho-pagina">
    <h1>Categorias</h1>
    <a class="botao" href="<?= base_url('admin/categorias/novo') ?>">Nova categoria</a>
</div>

<?php if (empty($categorias)): ?>
    <p>Nenhuma categoria cadastrada.</p>
<?php else: ?>
    <table class="tabela">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Slug</th>
                <th>Descricao</th>
                <th>Acoes</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categorias as $categoria): ?>
                <tr>
                    <td><?= $categoria['id'] ?></td>
                    <td><?= esc($categoria['nome']) ?></td>
                    <td><?= esc($categoria['slug']) ?></td>
                    <td><?= esc($categoria['descricao'] ?? '') ?></td>
                    <td>
                        <a class="botao botao-pequeno" href="<?= base_url('admin/categorias/editar/' . $categoria['id']) ?>">Editar</a>
                        <?= form_open('admin/categorias/excluir/' . $categoria['id'], ['onsubmit' => "return confirm('Excluir esta categoria?')"]) ?>
                            <button type="submit" class="botao botao-pequeno botao-perigo">Excluir</button>
                        <?= form_close() ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<div class="paginacao"><?= $pager->links() ?></div>

<?= $this->endSection() ?>