<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoModel extends Model
{
    protected $table            = 'produtos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'categoria_id',
        'nome',
        'slug',
        'descricao',
        'preco',
        'quantidade',
        'imagem',
        'destaque',
        'ativo',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'categoria_id' => 'required|is_not_unique[categorias.id]',
        'nome'         => 'required|min_length[3]|max_length[150]',
        'slug'         => 'required|regex_match[/^[a-z0-9-]+$/]|is_unique[produtos.slug,id,{id}]',
        'preco'        => 'required|decimal|greater_than[0]',
        'quantidade'   => 'required|integer|greater_than_equal_to[0]',
    ];

    protected $validationMessages = [
        'categoria_id' => [
            'required'      => 'Escolha uma categoria.',
            'is_not_unique' => 'A categoria informada não existe.',
        ],
        'nome' => [
            'required'   => 'O nome do produto é obrigatório.',
            'min_length' => 'O nome deve ter ao menos 3 caracteres.',
        ],
        'slug' => [
            'required'    => 'O slug é obrigatório.',
            'regex_match' => 'O slug pode conter apenas letras minusculas, numeros e hifens.',
            'is_unique'   => 'Este slug já está em uso.',
        ],
        'preco' => [
            'required'      => 'O preço é obrigatório.',
            'decimal'       => 'Informe um preço em formato decimal.',
            'greater_than'  => 'O preço deve ser maior que zero.',
        ],
        'quantidade' => [
            'required'               => 'A quantidade é obrigatória.',
            'integer'                => 'A quantidade deve ser um numero inteiro.',
            'greater_than_equal_to'  => 'A quantidade não pode ser negativa.',
        ],
    ];

    public function comCategoria()
    {
        return $this->select('produtos.*, categorias.nome AS nome_categoria')
            ->join('categorias', 'categorias.id = produtos.categoria_id', 'left');
    }
}