<?php

namespace App\Controllers;

use App\Libraries\Carrinho as CarrinhoService;
use App\Models\ProdutoModel;
use CodeIgniter\HTTP\RedirectResponse;

class Carrinho extends BaseController
{
    private function service(): CarrinhoService
    {
        return new CarrinhoService();
    }

    public function index(): string
    {
        $carrinho = $this->service();
        $itens = $carrinho->itens();

        $produtos = [];

        if (! empty($itens)) {
            $produtos = (new ProdutoModel())
                ->whereIn('id', array_keys($itens))
                ->findAll();
        }

        $itensDetalhados = [];

        foreach ($produtos as $produto) {
            $quantidade = $carrinho->quantidadeItem((int) $produto['id']);
            $itensDetalhados[] = [
                'produto'   => $produto,
                'quantidade' => $quantidade,
                'subtotal'  => ((float) $produto['preco']) * $quantidade,
            ];
        }

        $total = 0.0;

        foreach ($itensDetalhados as $item) {
            $total += $item['subtotal'];
        }

        $dados = [
            'titulo' => 'Carrinho de compras',
            'itens'  => $itensDetalhados,
            'total'  => $total,
        ];

        return view('carrinho/index', $dados);
    }

    public function adicionar(): RedirectResponse
    {
        $validacao = $this->validate([
            'produto_id' => 'required|is_not_unique[produtos.id]',
            'quantidade' => 'permit_empty|is_natural_no_zero',
        ]);

        if (! $validacao) {
            return redirect()->back()->with('erro', 'Produto invalido.');
        }

        $produto = (new ProdutoModel())->find((int) $this->request->getPost('produto_id'));

        if (! $produto || (int) $produto['ativo'] !== 1) {
            return redirect()->back()->with('erro', 'Produto indisponivel.');
        }

        $quantidade = (int) ($this->request->getPost('quantidade')) ?: 1;

        if ((int) $produto['quantidade'] === 0) {
            return redirect()->back()->with('erro', 'Este produto esta esgotado.');
        }

        $carrinho = $this->service();
        $naCarrinho = $carrinho->quantidadeItem((int) $produto['id']);

        if ($naCarrinho + $quantidade > (int) $produto['quantidade']) {
            return redirect()->back()->with('erro', 'Quantidade solicita excede o estoque disponivel.');
        }

        $carrinho->adicionar((int) $produto['id'], $quantidade);

        return redirect()->to('/carrinho')->with('sucesso', 'Produto adicionado ao carrinho.');
    }

    public function atualizar(int $produtoId): RedirectResponse
    {
        $carrinho = $this->service();

        if ($carrinho->quantidadeItem($produtoId) === 0) {
            return redirect()->to('/carrinho')->with('erro', 'Item não esta no carrinho.');
        }

        $validacao = $this->validate([
            'quantidade' => 'required|is_natural_no_zero',
        ]);

        if (! $validacao) {
            return redirect()->back()->with('erro', 'Quantidade invalida.');
        }

        $quantidade = (int) $this->request->getPost('quantidade');

        $produto = (new ProdutoModel())->find($produtoId);

        if (! $produto || $quantidade > (int) $produto['quantidade']) {
            return redirect()->to('/carrinho')->with('erro', 'Quantidade excede o estoque disponivel.');
        }

        $carrinho->atualizar($produtoId, $quantidade);

        return redirect()->to('/carrinho')->with('sucesso', 'Carrinho atualizado.');
    }

    public function remover(int $produtoId): RedirectResponse
    {
        $this->service()->remover($produtoId);

        return redirect()->to('/carrinho')->with('sucesso', 'Item removido do carrinho.');
    }
}