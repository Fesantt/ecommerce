<?= $this->extend('layouts/padrao') ?>

<?= $this->section('conteudo') ?>

<?= $menuAdmin ?>

<div class="cabecalho-pagina">
    <h1>Usuarios</h1>
    <a class="botao" href="<?= base_url('admin/usuarios/novo') ?>">Novo usuario</a>
</div>

<?= form_open('admin/usuarios', ['method' => 'get', 'class' => 'busca-form']) ?>
    <input type="text" name="q" value="<?= esc($busca) ?>" placeholder="Buscar por nome ou email...">
    <button type="submit" class="botao">Buscar</button>
<?= form_close() ?>

<table class="tabela">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Perfil</th>
            <th>Status</th>
            <th>Acoes</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?= $usuario['id'] ?></td>
                <td><?= esc($usuario['nome']) ?></td>
                <td><?= esc($usuario['email']) ?></td>
                <td>
                    <?php if ($usuario['perfil'] === 'admin'): ?>
                        <span class="badge badge-azul">Admin</span>
                    <?php else: ?>
                        <span class="badge badge-cinza">Cliente</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ((int) $usuario['ativo'] === 1): ?>
                        <span class="badge badge-verde">Ativo</span>
                    <?php else: ?>
                        <span class="badge badge-vermelho">Inativo</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a class="botao botao-pequeno" href="<?= base_url('admin/usuarios/editar/' . $usuario['id']) ?>">Editar</a>
                    <?php if ((int) $usuario['id'] !== (int) session()->get('usuario_id')): ?>
                        <?php if ((int) $usuario['ativo'] === 1): ?>
                            <?= form_open('admin/usuarios/desativar/' . $usuario['id'], ['class' => 'form-inline']) ?>
                                <button type="submit" class="botao botao-pequeno botao-perigo">Desativar</button>
                            <?= form_close() ?>
                        <?php else: ?>
                            <?= form_open('admin/usuarios/ativar/' . $usuario['id'], ['class' => 'form-inline']) ?>
                                <button type="submit" class="botao botao-pequeno botao-sucesso">Ativar</button>
                            <?= form_close() ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="paginacao"><?= $pager->links() ?></div>

<?= $this->endSection() ?>