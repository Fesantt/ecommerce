<?= $this->extend('layouts/padrao') ?>

<?= $this->section('conteudo') ?>

<h1>Meus pedidos</h1>

<?php if (empty($pedidos)): ?>
    <p>Você ainda nao fez nenhum pedido.</p>
<?php else: ?>
    <table class="tabela">
        <thead>
            <tr>
                <th>Numero</th>
                <th>Data</th>
                <th>Total</th>
                <th>Status</th>
                <th>Acoes</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td><?= esc($pedido['numero']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($pedido['created_at'])) ?></td>
                    <td>R$ <?= number_format((float) $pedido['total'], 2, ',', '.') ?></td>
                    <td>
                        <?php $cor = match ($pedido['status']) {
                            'pago'    => 'badge-verde',
                            'enviado' => 'badge-azul',
                            'cancelado' => 'badge-vermelho',
                            default   => 'badge-amarelo',
                        }; ?>
                        <span class="badge <?= $cor ?>"><?= esc($pedido['status']) ?></span>
                    </td>
                    <td>
                        <a class="botao botao-pequeno" href="<?= base_url('meus-pedidos/' . $pedido['id']) ?>">Ver detalhes</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<div class="paginacao"><?= $pager->links() ?></div>

<?= $this->endSection() ?>