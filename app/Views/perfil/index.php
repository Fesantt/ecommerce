<?= $this->extend('layouts/padrao') ?>

<?= $this->section('conteudo') ?>

<h1>Meu perfil</h1>

<?php $erros = session()->getFlashdata('erros') ?? []; ?>

<?php if (! empty($erros)): ?>
    <div class="aviso aviso-erro">
        <ul>
            <?php foreach ($erros as $erro): ?>
                <li><?= esc($erro) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?= form_open('perfil/atualizar') ?>
    <div class="form-grupo">
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" value="<?= esc(old('nome') ?? $usuario['nome']) ?>" required>
    </div>

    <div class="form-grupo">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?= esc(old('email') ?? $usuario['email']) ?>" required>
    </div>

    <button type="submit" class="botao">Salvar dados</button>
<?= form_close() ?>

<p class="link-extra">
    <a href="<?= base_url('perfil/senha') ?>">Alterar minha senha</a>
</p>

<?= $this->endSection() ?>