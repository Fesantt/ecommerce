<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('categorias')->insertBatch([
            ['nome' => 'Eletronicos', 'slug' => 'eletronicos', 'descricao' => 'Celulares, notebooks e acessorios.'],
            ['nome' => 'Roupas', 'slug' => 'roupas', 'descricao' => 'Moda masculina e feminina.'],
            ['nome' => 'Casa', 'slug' => 'casa', 'descricao' => 'Produtos para a sua casa.'],
        ]);
    }
}