<?= $this->extend('layouts/padrao') ?>

<?= $this->section('conteudo') ?>

<h1>Pedido <?= esc($pedido['numero']) ?></h1>

<?php $cor = match ($pedido['status']) {
    'pago'    => 'badge-verde',
    'enviado' => 'badge-azul',
    'cancelado' => 'badge-vermelho',
    default   => 'badge-amarelo',
}; ?>

<p>
    Data: <strong><?= date('d/m/Y H:i', strtotime($pedido['created_at'])) ?></strong> |
    Status: <span class="badge <?= $cor ?>"><?= esc($pedido['status']) ?></span>
</p>

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
                <td><?= esc($item['nome']) ?></td>
                <td>R$ <?= number_format((float) $item['preco_unitario'], 2, ',', '.') ?></td>
                <td><?= $item['quantidade'] ?></td>
                <td>R$ <?= number_format((float) $item['subtotal'], 2, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p class="total-carrinho">Total: <strong>R$ <?= number_format((float) $pedido['total'], 2, ',', '.') ?></strong></p>

<p class="link-extra"><a href="<?= base_url('/meus-pedidos') ?>">Voltar para meus pedidos</a></p>

<?= $this->endSection() ?>