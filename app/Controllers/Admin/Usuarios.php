<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use CodeIgniter\HTTP\RedirectResponse;

class Usuarios extends BaseController
{
    private function viewComMenu(string $view, array $dados): string
    {
        $dados['menuAdmin'] = view('layouts/_menu_admin');

        return view($view, $dados);
    }

    public function index(): string
    {
        $model = new UsuarioModel();
        $busca = (string) $this->request->getGet('q');

        if ($busca !== '') {
            $model->groupStart()
                ->like('nome', $busca)
                ->orLike('email', $busca)
                ->groupEnd();
        }

        $dados = [
            'titulo'   => 'Usuarios',
            'usuarios' => $model->orderBy('id', 'DESC')->paginate(10),
            'pager'    => $model->pager,
            'busca'    => $busca,
        ];

        return $this->viewComMenu('admin/usuarios/index', $dados);
    }

    public function novo(): string
    {
        $dados = [
            'titulo'  => 'Novo usuario',
            'usuario' => null,
        ];

        return $this->viewComMenu('admin/usuarios/form', $dados);
    }

    public function salvar(): RedirectResponse
    {
        $validacao = $this->validate([
            'nome'   => 'required|min_length[3]|max_length[120]',
            'email'  => 'required|valid_email|is_unique[usuarios.email]',
            'senha'  => 'required|min_length[6]',
            'perfil' => 'required|in_list[admin,cliente]',
        ]);

        if (! $validacao) {
            return redirect()->back()->withInput()->with('erros', $this->validator->getErrors());
        }

        (new UsuarioModel())->insert([
            'nome'   => $this->request->getPost('nome'),
            'email'  => $this->request->getPost('email'),
            'senha'  => password_hash((string) $this->request->getPost('senha'), PASSWORD_DEFAULT),
            'perfil' => $this->request->getPost('perfil'),
            'ativo'  => 1,
        ]);

        return redirect()->to('/admin/usuarios')->with('sucesso', 'Usuario cadastrado.');
    }

    public function editar(int $id): string|RedirectResponse
    {
        $usuario = (new UsuarioModel())->find($id);

        if (! $usuario) {
            return redirect()->to('/admin/usuarios')->with('erro', 'Usuario não encontrado.');
        }

        $dados = [
            'titulo'  => 'Editar usuario',
            'usuario' => $usuario,
        ];

        return $this->viewComMenu('admin/usuarios/form', $dados);
    }

    public function atualizar(int $id): RedirectResponse
    {
        $model = new UsuarioModel();
        $usuario = $model->find($id);

        if (! $usuario) {
            return redirect()->to('/admin/usuarios')->with('erro', 'Usuario não encontrado.');
        }

        $regras = [
            'nome'   => 'required|min_length[3]|max_length[120]',
            'email'  => 'required|valid_email|is_unique[usuarios.email,id,' . $id . ']',
            'perfil' => 'required|in_list[admin,cliente]',
        ];

        $senha = (string) $this->request->getPost('senha');

        if ($senha !== '') {
            $regras['senha'] = 'min_length[6]';
        }

        if (! $this->validate($regras)) {
            return redirect()->back()->withInput()->with('erros', $this->validator->getErrors());
        }

        $dados = [
            'nome'   => $this->request->getPost('nome'),
            'email'  => $this->request->getPost('email'),
            'perfil' => $this->request->getPost('perfil'),
        ];

        if ($senha !== '') {
            $dados['senha'] = password_hash($senha, PASSWORD_DEFAULT);
        }

        $model->update($id, $dados);

        return redirect()->to('/admin/usuarios')->with('sucesso', 'Usuario atualizado.');
    }

    public function desativar(int $id): RedirectResponse
    {
        if ($id === (int) session()->get('usuario_id')) {
            return redirect()->to('/admin/usuarios')->with('erro', 'Você não pode desativar sua propria conta.');
        }

        $model = new UsuarioModel();

        if (! $model->find($id)) {
            return redirect()->to('/admin/usuarios')->with('erro', 'Usuario não encontrado.');
        }

        $model->update($id, ['ativo' => 0]);

        return redirect()->to('/admin/usuarios')->with('sucesso', 'Usuario desativado.');
    }

    public function ativar(int $id): RedirectResponse
    {
        $model = new UsuarioModel();

        if (! $model->find($id)) {
            return redirect()->to('/admin/usuarios')->with('erro', 'Usuario não encontrado.');
        }

        $model->update($id, ['ativo' => 1]);

        return redirect()->to('/admin/usuarios')->with('sucesso', 'Usuario ativado.');
    }
}