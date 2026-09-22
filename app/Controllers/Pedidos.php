<?php

namespace App\Controllers;

use App\Models\PedidoItemModel;
use App\Models\PedidoModel;
use CodeIgniter\HTTP\RedirectResponse;

class Pedidos extends BaseController
{
    public function index(): string
    {
        $model = new PedidoModel();

        $dados = [
            'titulo'  => 'Meus pedidos',
            'pedidos' => $model->where('usuario_id', session()->get('usuario_id'))
                ->orderBy('id', 'DESC')
                ->paginate(10),
            'pager'   => $model->pager,
        ];

        return view('pedidos/index', $dados);
    }

    public function detalhe(int $id): string|RedirectResponse
    {
        $model = new PedidoModel();
        $pedido = $model->where('id', $id)
            ->where('usuario_id', session()->get('usuario_id'))
            ->first();

        if (! $pedido) {
            return redirect()->to('/meus-pedidos')->with('erro', 'Pedido não encontrado.');
        }

        $dados = [
            'titulo' => 'Pedido ' . $pedido['numero'],
            'pedido' => $pedido,
            'itens'  => (new PedidoItemModel())->comProduto($id),
        ];

        return view('pedidos/detalhe', $dados);
    }
}