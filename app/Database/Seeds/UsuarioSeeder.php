<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UsuarioModel;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        $model = new UsuarioModel();

        $model->insert([
            'nome'   => 'Administrador',
            'email'  => 'admin@ecommerce.test',
            'senha'  => password_hash('123456', PASSWORD_DEFAULT),
            'perfil' => 'admin',
            'ativo'  => 1,
        ]);

        $model->insert([
            'nome'   => 'Cliente Teste',
            'email'  => 'cliente@ecommerce.test',
            'senha'  => password_hash('123456', PASSWORD_DEFAULT),
            'perfil' => 'cliente',
            'ativo'  => 1,
        ]);
    }
}