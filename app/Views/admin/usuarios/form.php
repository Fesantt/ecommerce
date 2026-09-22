<?= $this->extend('layouts/padrao') ?>

<?= $this->section('conteudo') ?>

<?= $menuAdmin ?>

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

<h1><?= $usuario ? 'Editar usuario' : 'Novo usuario' ?></h1>

<?php if ($usuario): ?>
    <?= form_open('admin/usuarios/atualizar/' . $usuario['id']) ?>
<?php else: ?>
    <?= form_open('admin/usuarios/salvar') ?>
<?php endif; ?>

    <div class="form-grupo">
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" value="<?= esc(old('nome') ?? ($usuario['nome'] ?? '')) ?>" required>
    </div>

    <div class="form-grupo">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?= esc(old('email') ?? ($usuario['email'] ?? '')) ?>" required>
    </div>

    <div class="form-grupo">
        <label for="senha">Senha <?= $usuario ? '(deixe vazio para manter)' : '' ?></label>
        <input type="password" name="senha" id="senha" <?= $usuario ? '' : 'required' ?>>
    </div>

    <div class="form-grupo">
        <label for="perfil">Perfil</label>
        <select name="perfil" id="perfil" required>
            <option value="cliente" <?= old('perfil') === 'cliente' || (! empty($usuario) && $usuario['perfil'] === 'cliente') ? 'selected' : '' ?>>Cliente</option>
            <option value="admin" <?= old('perfil') === 'admin' || (! empty($usuario) && $usuario['perfil'] === 'admin') ? 'selected' : '' ?>>Administrador</option>
        </select>
    </div>

    <button type="submit" class="botao"><?= $usuario ? 'Salvar alteracoes' : 'Cadastrar' ?></button>
    <a class="botao botao-pequeno" href="<?= base_url('admin/usuarios') ?>">Voltar</a>
<?= form_close() ?>

<?= $this->endSection() ?>