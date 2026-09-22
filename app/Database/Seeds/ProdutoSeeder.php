<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    public function run()
    {
        $categoriaEletronicos = $this->db->table('categorias')->where('slug', 'eletronicos')->get()->getRow();
        $categoriaRoupas = $this->db->table('categorias')->where('slug', 'roupas')->get()->getRow();
        $categoriaCasa = $this->db->table('categorias')->where('slug', 'casa')->get()->getRow();

        $this->db->table('produtos')->insertBatch([
            [
                'categoria_id' => $categoriaEletronicos->id,
                'nome'         => 'Smartphone Modelo X',
                'slug'         => 'smartphone-modelo-x',
                'descricao'    => 'Celular com tela de 6 polegadas e 128GB.',
                'preco'        => 1899.90,
                'quantidade'   => 10,
                'destaque'     => 1,
                'ativo'        => 1,
            ],
            [
                'categoria_id' => $categoriaEletronicos->id,
                'nome'         => 'Fone Bluetooth',
                'slug'         => 'fone-bluetooth',
                'descricao'    => 'Fone sem fio com estojo de carga.',
                'preco'        => 149.90,
                'quantidade'   => 25,
                'destaque'     => 1,
                'ativo'        => 1,
            ],
            [
                'categoria_id' => $categoriaRoupas->id,
                'nome'         => 'Camiseta Básica',
                'slug'         => 'camiseta-basica',
                'descricao'    => 'Camiseta 100% algodao, varios tamanhos.',
                'preco'        => 49.90,
                'quantidade'   => 40,
                'destaque'     => 0,
                'ativo'        => 1,
            ],
            [
                'categoria_id' => $categoriaCasa->id,
                'nome'         => 'Luminaria LED',
                'slug'         => 'luminaria-led',
                'descricao'    => 'Abajur com luz amarela e branca.',
                'preco'        => 89.00,
                'quantidade'   => 15,
                'destaque'     => 0,
                'ativo'        => 1,
            ],
            [
                'categoria_id' => $categoriaCasa->id,
                'nome'         => 'Caneca Ceramica',
                'slug'         => 'caneca-ceramica',
                'descricao'    => 'Caneca de ceramica 300ml.',
                'preco'        => 29.90,
                'quantidade'   => 0,
                'destaque'     => 0,
                'ativo'        => 1,
            ],
        ]);
    }
}