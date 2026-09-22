<?= $this->extend('layouts/padrao') ?>

<?= $this->section('conteudo') ?>

<h1>Trocar senha</h1>

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

<?= form_open('conta/senha/salvar') ?>
    <div class="form-grupo">
        <label for="senha_atual">Senha atual</label>
        <input type="password" name="senha_atual" id="senha_atual" required>
    </div>

    <div class="form-grupo">
        <label for="nova_senha">Nova senha</label>
        <input type="password" name="nova_senha" id="nova_senha" required>
    </div>

    <div class="form-grupo">
        <label for="confirmar_nova_senha">Confirmar nova senha</label>
        <input type="password" name="confirmar_nova_senha" id="confirmar_nova_senha" required>
    </div>

    <button type="submit" class="botao">Salvar nova senha</button>
<?= form_close() ?>

<?= $this->endSection() ?>