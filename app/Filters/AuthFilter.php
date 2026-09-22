<?php

namespace App\Filters;

use App\Models\UsuarioModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null): ?ResponseInterface
    {
        $usuarioId = session()->get('usuario_id');

        if (! $usuarioId) {
            return redirect()->to('/login')->with('erro', 'Faça login para continuar.');
        }

        $usuario = (new UsuarioModel())->find($usuarioId);

        if (! $usuario || (int) $usuario['ativo'] !== 1) {
            session()->destroy();

            return redirect()->to('/login')->with('erro', 'Sua conta esta desativada.');
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null): void
    {
    }
}