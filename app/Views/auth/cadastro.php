<?= $this->extend('layouts/padrao') ?>

<?= $this->section('conteudo') ?>

<h1>Criar conta</h1>

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

<?= form_open('cadastro/salvar') ?>
    <div class="form-grupo">
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" value="<?= esc(old('nome')) ?>" required>
    </div>

    <div class="form-grupo">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?= esc(old('email')) ?>" required>
    </div>

    <div class="form-grupo">
        <label for="senha">Senha</label>
        <input type="password" name="senha" id="senha" required>
    </div>

    <div class="form-grupo">
        <label for="confirmar_senha">Confirmar senha</label>
        <input type="password" name="confirmar_senha" id="confirmar_senha" required>
    </div>

    <button type="submit" class="botao">Criar conta</button>
<?= form_close() ?>

<p class="link-extra">Ja tem conta? <a href="<?= base_url('login') ?>">Entre aqui</a>.</p>

<?= $this->endSection() ?>