<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($titulo) ? esc($titulo) . ' - ' . 'Loja Virtual' : 'Loja Virtual' ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/estilos.css') ?>">
</head>
<body>
    <header class="topo">
        <div class="container topo-inner">
            <a class="logo" href="<?= base_url('/') ?>">Loja Virtual</a>
            <nav class="menu">
                <a class="menu-carrinho" href="<?= base_url('/carrinho') ?>">Carrinho
                    <?php $carrinho = session()->get('carrinho') ?? []; $itensCarrinho = array_sum(array_column($carrinho, 'quantidade')); ?>
                    <?php if ($itensCarrinho > 0): ?>
                        <span class="menu-carrinho-contador"><?= $itensCarrinho ?></span>
                    <?php endif; ?>
                </a>
                <?php if (session()->get('usuario_id')): ?>
                    <?php if (session()->get('perfil') === 'admin'): ?>
                        <a class="menu-admin-link" href="<?= base_url('/admin') ?>">Administrar</a>
                    <?php endif; ?>
                    <span class="menu-usuario"><?= esc(session()->get('usuario_nome')) ?></span>
                    <a href="<?= base_url('/meus-pedidos') ?>">Meus pedidos</a>
                    <a href="<?= base_url('/perfil') ?>">Meu perfil</a>
                    <a href="<?= base_url('/logout') ?>">Sair</a>
                <?php else: ?>
                    <a href="<?= base_url('/login') ?>">Entrar</a>
                    <a href="<?= base_url('/cadastro') ?>">Criar conta</a>
                <?php endif; ?>
            </nav>
        </div>
        <?= $this->renderSection('navLoja') ?>
    </header>

    <?php if (session()->getFlashdata('sucesso')): ?>
        <div class="container aviso aviso-sucesso"><?= esc(session()->getFlashdata('sucesso')) ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('erro')): ?>
        <div class="container aviso aviso-erro"><?= esc(session()->getFlashdata('erro')) ?></div>
    <?php endif; ?>

    <main class="container conteudo">
        <?= $this->renderSection('conteudo') ?>
    </main>

    <footer class="rodape">
        <div class="container">Loja Virtual - Projeto de curso com CodeIgniter 4</div>
    </footer>
</body>
</html>