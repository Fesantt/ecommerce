<?= $this->extend('layouts/padrao') ?>

<?= $this->section('conteudo') ?>

<?= $menuAdmin ?>

<h1>Painel administrativo</h1>

<?php if ($pedidosPendentes > 0): ?>
    <div class="aviso aviso-erro">Existem <?= $pedidosPendentes ?> pedido(s) pendente(s) aguardando atencao.</div>
<?php endif; ?>

<div class="cards-grid">
    <div class="card-resumo">
        <span class="card-resumo-rotulo">Produtos</span>
        <span class="card-resumo-valor"><?= $qtdProdutos ?></span>
    </div>
    <div class="card-resumo">
        <span class="card-resumo-rotulo">Categorias</span>
        <span class="card-resumo-valor"><?= $qtdCategorias ?></span>
    </div>
    <div class="card-resumo">
        <span class="card-resumo-rotulo">Pedidos</span>
        <span class="card-resumo-valor"><?= $qtdPedidos ?></span>
    </div>
    <div class="card-resumo">
        <span class="card-resumo-rotulo">Faturamento (pago)</span>
        <span class="card-resumo-valor">R$ <?= number_format($faturamento, 2, ',', '.') ?></span>
    </div>
</div>

<div class="dashboard-linhas">
    <section class="painel">
        <h2>Mais vendidos</h2>
        <?php if (empty($maisVendidos)): ?>
            <p>Sem vendas registradas.</p>
        <?php else: ?>
            <ol>
                <?php foreach ($maisVendidos as $produto): ?>
                    <li>
                        <?= esc($produto['nome']) ?>
                        <span class="badge badge-verde"><?= $produto['total_vendido'] ?> vendidos</span>
                    </li>
                <?php endforeach; ?>
            </ol>
        <?php endif; ?>
    </section>

    <section class="painel">
        <h2>Estoque baixo</h2>
        <?php if (empty($estoqueBaixo)): ?>
            <p>Todos os produtos com estoque adequado.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($estoqueBaixo as $produto): ?>
                    <li>
                        <?= esc($produto['nome']) ?>
                        <span class="badge badge-amarelo"><?= $produto['quantidade'] ?> em estoque</span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </section>
</div>

<?= $this->endSection() ?>