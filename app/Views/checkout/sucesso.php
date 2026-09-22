<?= $this->extend('layouts/padrao') ?>

<?= $this->section('conteudo') ?>

<h1>Pedido confirmado</h1>

<p>Seu pedido <strong><?= esc($pedido['numero']) ?></strong> foi registrado no valor de
    <strong>R$ <?= number_format((float) $pedido['total'], 2, ',', '.') ?></strong>.</p>
<p>Você pode acompanhar o status em <a href="<?= base_url('/meus-pedidos') ?>">Meus pedidos</a>.</p>

<a class="botao" href="<?= base_url('/') ?>">Continuar comprando</a>

<?= $this->endSection() ?>