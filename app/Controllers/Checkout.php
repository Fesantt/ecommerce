<?php

namespace App\Controllers;

use App\Libraries\Carrinho;
use App\Models\PedidoItemModel;
use App\Models\PedidoModel;
use App\Models\ProdutoModel;
use CodeIgniter\HTTP\RedirectResponse;

class Checkout extends BaseController
{
    public function index(): string|RedirectResponse
    {
        $carrinho = new Carrinho();
        $itens = $carrinho->itens();

        if (empty($itens)) {
            return redirect()->to('/carrinho')->with('erro', 'Seu carrinho esta vazio.');
        }

        $produtos = (new ProdutoModel())->whereIn('id', array_keys($itens))->findAll();
        $itensDetalhados = [];
        $total = 0.0;

        foreach ($produtos as $produto) {
            $quantidade = $carrinho->quantidadeItem((int) $produto['id']);
            $subtotal = ((float) $produto['preco']) * $quantidade;
            $total += $subtotal;

            $itensDetalhados[] = [
                'produto'    => $produto,
                'quantidade' => $quantidade,
                'subtotal'   => $subtotal,
            ];
        }

        $dados = [
            'titulo' => 'Finalizar compra',
            'itens'  => $itensDetalhados,
            'total'  => $total,
        ];

        return view('checkout/index', $dados);
    }

    public function confirmar(): RedirectResponse
    {
        $carrinho = new Carrinho();
        $itens = $carrinho->itens();

        if (empty($itens)) {
            return redirect()->to('/carrinho')->with('erro', 'Seu carrinho esta vazio.');
        }

        $produtoModel = new ProdutoModel();
        $validados = [];

        foreach ($itens as $item) {
            $produto = $produtoModel->find((int) $item['produto_id']);

            if (! $produto || (int) $produto['ativo'] !== 1) {
                return redirect()->to('/carrinho')->with('erro', 'Um dos produtos nao esta mais disponivel.');
            }

            $quantidade = (int) $item['quantidade'];

            if ($quantidade < 1 || $quantidade > (int) $produto['quantidade']) {
                return redirect()->to('/carrinho')->with('erro', 'Estoque insuficiente para ' . $produto['nome'] . '.');
            }

            $validados[] = [
                'produto' => $produto,
                'quantidade' => $quantidade,
            ];
        }

        $db = db_connect();
        $db->transBegin();

        $pedidoModel = new PedidoModel();
        $itemModel = new PedidoItemModel();

        $numero = 'PED-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));

        $pedidoModel->insert([
            'usuario_id' => session()->get('usuario_id'),
            'numero'     => $numero,
            'status'     => 'pendente',
            'total'      => 0.00,
        ]);

        $pedidoId = $pedidoModel->getInsertID();
        $total = 0.0;

        foreach ($validados as $dados) {
            $produto = $dados['produto'];
            $quantidade = $dados['quantidade'];
            $subtotal = ((float) $produto['preco']) * $quantidade;
            $total += $subtotal;

            $itemModel->insert([
                'pedido_id'      => $pedidoId,
                'produto_id'     => $produto['id'],
                'preco_unitario' => $produto['preco'],
                'quantidade'     => $quantidade,
                'subtotal'       => $subtotal,
            ]);

            $produtoModel->update($produto['id'], [
                'quantidade' => (int) $produto['quantidade'] - $quantidade,
            ]);
        }

        $pedidoModel->update($pedidoId, ['total' => $total]);

        if ($db->transStatus() === false) {
            $db->transRollback();

            return redirect()->to('/carrinho')->with('erro', 'Nao foi possivel finalizar o pedido. Tente novamente.');
        }

        $db->transCommit();

        $carrinho->limpar();

        return redirect()->to('/checkout/sucesso/' . $pedidoId)->with('sucesso', 'Pedido confirmado com sucesso!');
    }

    public function sucesso(int $id): string|RedirectResponse
    {
        $pedido = (new PedidoModel())
            ->where('id', $id)
            ->where('usuario_id', session()->get('usuario_id'))
            ->first();

        if (! $pedido) {
            return redirect()->to('/meus-pedidos')->with('erro', 'Pedido não encontrado.');
        }

        $dados = [
            'titulo' => 'Pedido confirmado',
            'pedido' => $pedido,
        ];

        return view('checkout/sucesso', $dados);
    }
}