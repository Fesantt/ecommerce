<article class="card-produto">
    <div class="card-imagem">
        <?php if ($produto['imagem']): ?>
            <img src="<?= base_url('uploads/' . $produto['imagem']) ?>" alt="<?= esc($produto['nome']) ?>">
        <?php else: ?>
            <span>Sem imagem</span>
        <?php endif; ?>
    </div>
    <div class="card-corpo">
        <a class="card-nome" href="<?= base_url('produto/' . $produto['slug']) ?>"><?= esc($produto['nome']) ?></a>
        <span class="card-preco">R$ <?= number_format((float) $produto['preco'], 2, ',', '.') ?></span>
        <?php if ((int) $produto['quantidade'] === 0): ?>
            <span class="badge badge-vermelho">Esgotado</span>
        <?php endif; ?>
        <div class="card-acoes">
            <a class="botao botao-pequeno" href="<?= base_url('produto/' . $produto['slug']) ?>">Ver detalhes</a>
        </div>
    </div>
</article>