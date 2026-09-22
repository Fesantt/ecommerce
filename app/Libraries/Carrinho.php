<?php

namespace App\Libraries;

class Carrinho
{
    private const CHAVE_SESSAO = 'carrinho';

    public function itens(): array
    {
        return session()->get(self::CHAVE_SESSAO) ?? [];
    }

    public function quantidadeItem(int $produtoId): int
    {
        $itens = $this->itens();

        return $itens[$produtoId]['quantidade'] ?? 0;
    }

    public function quantidadeItens(): int
    {
        $total = 0;

        foreach ($this->itens() as $item) {
            $total += $item['quantidade'];
        }

        return $total;
    }

    public function adicionar(int $produtoId, int $quantidade): void
    {
        $itens = $this->itens();

        $itens[$produtoId] = [
            'produto_id' => $produtoId,
            'quantidade' => $quantidade + $this->quantidadeItem($produtoId),
        ];

        session()->set(self::CHAVE_SESSAO, $itens);
    }

    public function atualizar(int $produtoId, int $quantidade): void
    {
        $itens = $this->itens();

        if (isset($itens[$produtoId])) {
            $itens[$produtoId]['quantidade'] = $quantidade;
        }

        session()->set(self::CHAVE_SESSAO, $itens);
    }

    public function remover(int $produtoId): void
    {
        $itens = $this->itens();

        unset($itens[$produtoId]);

        session()->set(self::CHAVE_SESSAO, $itens);
    }

    public function limpar(): void
    {
        session()->remove(self::CHAVE_SESSAO);
    }
}