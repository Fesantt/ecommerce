<?= $this->extend('layouts/padrao') ?>

<?= $this->section('conteudo') ?>

<?= $menuAdmin ?>

<div class="cabecalho-pagina">
    <h1>Produtos</h1>
    <a class="botao" href="<?= base_url('admin/produtos/novo') ?>">Novo produto</a>
</div>

<?= form_open('admin/produtos', ['method' => 'get', 'class' => 'busca-form']) ?>
    <input type="text" name="q" value="<?= esc($busca) ?>" placeholder="Buscar por nome...">
    <select name="categoria">
        <option value="">Todas as categorias</option>
        <?php foreach ($categorias as $categoria): ?>
            <option value="<?= $categoria['id'] ?>" <?= $categoriaAtual === (int) $categoria['id'] ? 'selected' : '' ?>>
                <?= esc($categoria['nome']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit" class="botao">Filtrar</button>
<?= form_close() ?>

<?php if (empty($produtos)): ?>
    <p>Nenhum produto encontrado.</p>
<?php else: ?>
    <table class="tabela">
        <thead>
            <tr>
                <th>ID</th>
                <th>Imagem</th>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Preco</th>
                <th>Estoque</th>
                <th>Status</th>
                <th>Acoes</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produtos as $produto): ?>
                <tr>
                    <td><?= $produto['id'] ?></td>
                    <td>
                        <?php if ($produto['imagem']): ?>
                            <img src="<?= base_url('uploads/' . $produto['imagem']) ?>" alt="<?= esc($produto['nome']) ?>" class="thumb">
                        <?php else: ?>
                            <span class="thumb vazio">-</span>
                        <?php endif; ?>
                    </td>
                    <td><?= esc($produto['nome']) ?></td>
                    <td><?= esc($produto['nome_categoria']) ?></td>
                    <td>R$ <?= number_format((float) $produto['preco'], 2, ',', '.') ?></td>
                    <td>
                        <?= $produto['quantidade'] ?>
                        <?php if ((int) $produto['quantidade'] === 0): ?>
                            <span class="badge badge-vermelho">Esgotado</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ((int) $produto['ativo'] === 1): ?>
                            <span class="badge badge-verde">Ativo</span>
                        <?php else: ?>
                            <span class="badge badge-cinza">Inativo</span>
                        <?php endif; ?>
                        <?php if ((int) $produto['destaque'] === 1): ?>
                            <span class="badge badge-amarelo">Destaque</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a class="botao botao-pequeno" href="<?= base_url('admin/produtos/editar/' . $produto['id']) ?>">Editar</a>
                        <?= form_open('admin/produtos/excluir/' . $produto['id'], ['onsubmit' => "return confirm('Excluir este produto?')"]) ?>
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