<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoItemModel extends Model
{
    protected $table            = 'pedido_itens';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'pedido_id',
        'produto_id',
        'preco_unitario',
        'quantidade',
        'subtotal',
    ];
    protected $useTimestamps = false;

    public function comProduto(int $pedidoId)
    {
        return $this->select('pedido_itens.*, produtos.nome, produtos.imagem, produtos.slug')
            ->join('produtos', 'produtos.id = pedido_itens.produto_id')
            ->where('pedido_id', $pedidoId)
            ->findAll();
    }
}