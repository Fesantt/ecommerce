<?= $this->extend('layouts/padrao') ?>

<?= $this->section('conteudo') ?>

<h1>Carrinho de compras</h1>

<?php if (empty($itens)): ?>
    <p>Seu carrinho esta vazio.</p>
    <p><a class="botao" href="<?= base_url('/') ?>">Continuar comprando</a></p>
<?php else: ?>
    <table class="tabela">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Preco unit.</th>
                <th>Quantidade</th>
                <th>Subtotal</th>
                <th>Acoes</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($itens as $item): ?>
                <tr>
                    <td>
                        <a href="<?= base_url('produto/' . $item['produto']['slug']) ?>"><?= esc($item['produto']['nome']) ?></a>
                    </td>
                    <td>R$ <?= number_format((float) $item['produto']['preco'], 2, ',', '.') ?></td>
                    <td>
                        <?= form_open('carrinho/atualizar/' . $item['produto']['id'], ['class' => 'form-quantidade']) ?>
                            <input type="number" name="quantidade" min="1" max="<?= $item['produto']['quantidade'] ?>" value="<?= $item['quantidade'] ?>" required>
                            <button type="submit" class="botao botao-pequeno">Atualizar</button>
                        <?= form_close() ?>
                    </td>
                    <td>R$ <?= number_format((float) $item['subtotal'], 2, ',', '.') ?></td>
                    <td>
                        <?= form_open('carrinho/remover/' . $item['produto']['id']) ?>
                            <button type="submit" class="botao botao-pequeno botao-perigo">Remover</button>
                        <?= form_close() ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p class="total-carrinho">Total: <strong>R$ <?= number_format((float) $total, 2, ',', '.') ?></strong></p>

    <a class="botao" href="<?= base_url('/') ?>">Continuar comprando</a>
<?php endif; ?>

<?= $this->endSection() ?>