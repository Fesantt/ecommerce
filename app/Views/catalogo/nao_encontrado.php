<?= $this->extend('layouts/padrao') ?>

<?= $this->section('conteudo') ?>

<h1><?= esc($titulo) ?></h1>
<p>O conteudo solicitado não existe ou nao esta disponivel.</p>
<p><a href="<?= base_url('/') ?>">Voltar para a loja</a></p>

<?= $this->endSection() ?>