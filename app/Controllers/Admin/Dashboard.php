<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $db = db_connect();

        $qtdProdutos = $db->table('produtos')->countAllResults();
        $qtdCategorias = $db->table('categorias')->countAllResults();
        $qtdPedidos = $db->table('pedidos')->countAllResults();
        $pedidosPendentes = $db->table('pedidos')->where('status', 'pendente')->countAllResults();

        $faturamento = $db->table('pedidos')
            ->selectSum('total', 'total')
            ->where('status', 'pago')
            ->get()
            ->getRow()
            ->total ?? 0;

        $maisVendidos = $db->table('pedido_itens')
            ->select('produtos.id, produtos.nome, produtos.imagem, SUM(pedido_itens.quantidade) AS total_vendido')
            ->join('produtos', 'produtos.id = pedido_itens.produto_id', 'left')
            ->groupBy('produtos.id, produtos.nome')
            ->orderBy('total_vendido', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        $estoqueBaixo = $db->table('produtos')
            ->select('id, nome, quantidade')
            ->where('quantidade <=', 5)
            ->orderBy('quantidade', 'ASC')
            ->limit(5)
            ->get()
            ->getResultArray();

        $dados = [
            'titulo'         => 'Painel administrativo',
            'qtdProdutos'    => $qtdProdutos,
            'qtdCategorias'  => $qtdCategorias,
            'qtdPedidos'     => $qtdPedidos,
            'pedidosPendentes' => $pedidosPendentes,
            'faturamento'    => (float) $faturamento,
            'maisVendidos'   => $maisVendidos,
            'estoqueBaixo'   => $estoqueBaixo,
        ];

        $dados['menuAdmin'] = view('layouts/_menu_admin');

        return view('admin/dashboard', $dados);
    }
}