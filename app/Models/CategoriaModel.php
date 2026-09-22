<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriaModel extends Model
{
    protected $table            = 'categorias';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nome', 'slug', 'descricao'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $validationRules = [
        'nome'  => 'required|min_length[3]|max_length[100]',
        'slug'  => 'required|regex_match[/^[a-z0-9-]+$/]|is_unique[categorias.slug,id,{id}]',
    ];

    protected $validationMessages = [
        'nome' => [
            'required'   => 'O nome da categoria é obrigatório.',
            'min_length' => 'O nome deve ter ao menos 3 caracteres.',
        ],
        'slug' => [
            'required'    => 'O slug é obrigatório.',
            'regex_match' => 'O slug pode conter apenas letras minusculas, numeros e hifens.',
            'is_unique'   => 'Este slug já está em uso.',
        ],
    ];
}