<?= $this->extend('layouts/padrao') ?>

<?= $this->section('conteudo') ?>

<?= $menuAdmin ?>

<h1>Pedidos</h1>

<?= form_open('admin/pedidos', ['method' => 'get', 'class' => 'busca-form']) ?>
    <input type="text" name="q" value="<?= esc($busca) ?>" placeholder="Numero do pedido...">
    <select name="status">
        <option value="">Todos os status</option>
        <?php foreach ($statusDisponiveis as $status): ?>
            <option value="<?= esc($status) ?>" <?= $statusAtual === $status ? 'selected' : '' ?>><?= esc($status) ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit" class="botao">Filtrar</button>
<?= form_close() ?>

<?php if (empty($pedidos)): ?>
    <p>Nenhum pedido encontrado.</p>
<?php else: ?>
    <table class="tabela">
        <thead>
            <tr>
                <th>Numero</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Status</th>
                <th>Data</th>
                <th>Acoes</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td><?= esc($pedido['numero']) ?></td>
                    <td>
                        <?= esc($pedido['nome']) ?>
                        <br><small><?= esc($pedido['email']) ?></small>
                    </td>
                    <td>R$ <?= number_format((float) $pedido['total'], 2, ',', '.') ?></td>
                    <td>
                        <?php $cor = match ($pedido['status']) {
                            'pago'      => 'badge-verde',
                            'enviado'   => 'badge-azul',
                            'cancelado' => 'badge-vermelho',
                            default     => 'badge-amarelo',
                        }; ?>
                        <span class="badge <?= $cor ?>"><?= esc($pedido['status']) ?></span>
                    </td>
                    <td><?= date('d/m/Y H:i', strtotime($pedido['created_at'])) ?></td>
                    <td>
                        <a class="botao botao-pequeno" href="<?= base_url('admin/pedidos/detalhe/' . $pedido['id']) ?>">Detalhes</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<div class="paginacao"><?= $pager->links() ?></div>

<?= $this->endSection() ?>