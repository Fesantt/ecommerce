<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null): ?ResponseInterface
    {
        if (! session()->get('usuario_id')) {
            return redirect()->to('/login')->with('erro', 'Faça login para continuar.');
        }

        if (session()->get('perfil') !== 'admin') {
            return redirect()->to('/')->with('erro', 'Acesso restrito ao administrador.');
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null): void
    {
    }
}