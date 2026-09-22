<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PedidoItemModel;
use App\Models\PedidoModel;
use App\Models\ProdutoModel;
use App\Models\UsuarioModel;
use CodeIgniter\HTTP\RedirectResponse;

class Pedidos extends BaseController
{
    private function viewComMenu(string $view, array $dados): string
    {
        $dados['menuAdmin'] = view('layouts/_menu_admin');

        return view($view, $dados);
    }

    public function index(): string
    {
        $model = new PedidoModel();
        $model->select('pedidos.*, usuarios.nome, usuarios.email');
        $model->join('usuarios', 'usuarios.id = pedidos.usuario_id');

        $status = (string) $this->request->getGet('status');
        $numero = (string) $this->request->getGet('q');

        if ($status !== '' && in_array($status, PedidoModel::STATUS, true)) {
            $model->where('pedidos.status', $status);
        }

        if ($numero !== '') {
            $model->like('pedidos.numero', $numero);
        }

        $dados = [
            'titulo'   => 'Pedidos',
            'pedidos'  => $model->orderBy('pedidos.id', 'DESC')->paginate(10),
            'pager'    => $model->pager,
            'statusAtual' => $status,
            'busca'    => $numero,
            'statusDisponiveis' => PedidoModel::STATUS,
        ];

        return $this->viewComMenu('admin/pedidos/index', $dados);
    }

    public function detalhe(int $id): string|RedirectResponse
    {
        $model = new PedidoModel();
        $model->select('pedidos.*, usuarios.nome, usuarios.email');
        $model->join('usuarios', 'usuarios.id = pedidos.usuario_id');

        $pedido = $model->where('pedidos.id', $id)->first();

        if (! $pedido) {
            return redirect()->to('/admin/pedidos')->with('erro', 'Pedido não encontrado.');
        }

        $dados = [
            'titulo' => 'Pedido ' . $pedido['numero'],
            'pedido' => $pedido,
            'itens'  => (new PedidoItemModel())->comProduto($id),
            'statusDisponiveis' => PedidoModel::STATUS,
        ];

        return $this->viewComMenu('admin/pedidos/detalhe', $dados);
    }

    public function status(int $id): RedirectResponse
    {
        $validacao = $this->validate([
            'status' => 'required|in_list[pendente,pago,enviado,cancelado]',
        ]);

        if (! $validacao) {
            return redirect()->back()->with('erro', 'Status invalido.');
        }

        $pedidoModel = new PedidoModel();
        $pedido = $pedidoModel->find($id);

        if (! $pedido) {
            return redirect()->to('/admin/pedidos')->with('erro', 'Pedido não encontrado.');
        }

        $novoStatus = (string) $this->request->getPost('status');

        if ($novoStatus === $pedido['status']) {
            return redirect()->to('/admin/pedidos/detalhe/' . $id)->with('sucesso', 'Status inalterado.');
        }

        if (in_array($pedido['status'], ['cancelado'], true)) {
            return redirect()->to('/admin/pedidos/detalhe/' . $id)->with('erro', 'Pedido cancelado não pode mudar de status.');
        }

        if ($novoStatus === 'pendente' && in_array($pedido['status'], ['pago', 'enviado'], true)) {
            return redirect()->to('/admin/pedidos/detalhe/' . $id)->with('erro', 'Nao e possivel voltar para pendente.');
        }

        $devolveEstoque = $novoStatus === 'cancelado'
            && in_array($pedido['status'], ['pendente', 'pago', 'enviado'], true);

        $db = db_connect();
        $db->transBegin();

        if ($devolveEstoque) {
            $itens = (new PedidoItemModel())->where('pedido_id', $id)->findAll();
            $produtoModel = new ProdutoModel();

            foreach ($itens as $item) {
                $produto = $produtoModel->find($item['produto_id']);

                if ($produto) {
                    $produtoModel->update($produto['id'], [
                        'quantidade' => (int) $produto['quantidade'] + (int) $item['quantidade'],
                    ]);
                }
            }
        }

        $pedidoModel->update($id, ['status' => $novoStatus]);

        if ($db->transStatus() === false) {
            $db->transRollback();

            return redirect()->to('/admin/pedidos/detalhe/' . $id)->with('erro', 'Nao foi possivel atualizar o pedido.');
        }

        $db->transCommit();

        return redirect()->to('/admin/pedidos/detalhe/' . $id)->with('sucesso', 'Status do pedido atualizado.');
    }
}