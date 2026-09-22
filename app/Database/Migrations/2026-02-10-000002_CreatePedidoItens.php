<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePedidoItens extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'pedido_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'produto_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'preco_unitario' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'quantidade' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'subtotal' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('pedido_id');
        $this->forge->addKey('produto_id');
        $this->forge->addForeignKey('pedido_id', 'pedidos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('produto_id', 'produtos', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('pedido_itens');
    }

    public function down()
    {
        $this->forge->dropTable('pedido_itens');
    }
}