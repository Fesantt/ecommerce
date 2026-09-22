<?= $this->extend('layouts/padrao') ?>

<?= $this->section('conteudo') ?>

<?= $menuAdmin ?>

<h1>Pedido <?= esc($pedido['numero']) ?></h1>

<p>
    Cliente: <strong><?= esc($pedido['nome']) ?></strong> (<?= esc($pedido['email']) ?>) |
    Data: <strong><?= date('d/m/Y H:i', strtotime($pedido['created_at'])) ?></strong>
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

<div class="box-status">
    <?= form_open('admin/pedidos/status/' . $pedido['id']) ?>
        <label for="status">Alterar status</label>
        <select name="status" id="status">
            <?php foreach ($statusDisponiveis as $status): ?>
                <option value="<?= esc($status) ?>" <?= $pedido['status'] === $status ? 'selected' : '' ?>><?= esc($status) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="botao botao-pequeno">Salvar status</button>
    <?= form_close() ?>
</div>

<p class="link-extra"><a href="<?= base_url('admin/pedidos') ?>">Voltar para pedidos</a></p>

<?= $this->endSection() ?>