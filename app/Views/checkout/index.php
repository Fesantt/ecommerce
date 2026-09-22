<?= $this->extend('layouts/padrao') ?>

<?= $this->section('conteudo') ?>

<h1>Finalizar compra</h1>

<table class="tabela">
    <thead>
        <tr>
            <th>Produto</th>
            <th>Preco unit.</th>
            <th>Quantidade</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($itens as $item): ?>
            <tr>
                <td><?= esc($item['produto']['nome']) ?></td>
                <td>R$ <?= number_format((float) $item['produto']['preco'], 2, ',', '.') ?></td>
                <td><?= $item['quantidade'] ?></td>
                <td>R$ <?= number_format((float) $item['subtotal'], 2, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p class="total-carrinho">Total: <strong>R$ <?= number_format((float) $total, 2, ',', '.') ?></strong></p>

<?= form_open('checkout/confirmar') ?>
    <button type="submit" class="botao botao-sucesso">Confirmar pedido</button>
<?= form_close() ?>

<p class="link-extra"><a href="<?= base_url('/carrinho') ?>">Voltar ao carrinho</a></p>

<?= $this->endSection() ?>