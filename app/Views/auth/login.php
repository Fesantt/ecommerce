<?= $this->extend('layouts/padrao') ?>

<?= $this->section('conteudo') ?>

<h1>Entrar</h1>

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

<?= form_open('login/salvar') ?>
    <div class="form-grupo">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?= esc(old('email')) ?>" required>
    </div>

    <div class="form-grupo">
        <label for="senha">Senha</label>
        <input type="password" name="senha" id="senha" required>
    </div>

    <button type="submit" class="botao">Entrar</button>
<?= form_close() ?>

<p class="link-extra">Ainda nao tem conta? <a href="<?= base_url('cadastro') ?>">Crie agora</a>.</p>

<?= $this->endSection() ?>