<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nome', 'email', 'senha', 'perfil', 'ativo'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $validationRules = [
        'nome'  => 'required|min_length[3]|max_length[120]',
        'email' => 'required|valid_email|is_unique[usuarios.email,id,{id}]',
        'senha' => 'required|min_length[6]',
    ];

    protected $validationMessages = [
        'nome' => [
            'required'   => 'O nome é obrigatório.',
            'min_length' => 'O nome deve ter ao menos 3 caracteres.',
        ],
        'email' => [
            'required'    => 'O email é obrigatório.',
            'valid_email' => 'Informe um email válido.',
            'is_unique'   => 'Este email já está cadastrado.',
        ],
        'senha' => [
            'required'   => 'A senha é obrigatória.',
            'min_length' => 'A senha deve ter ao menos 6 caracteres.',
        ],
    ];
}