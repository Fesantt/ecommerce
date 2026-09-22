<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\HTTP\RedirectResponse;

class Perfil extends BaseController
{
    public function index(): string
    {
        $usuario = (new UsuarioModel())->find(session()->get('usuario_id'));

        $dados = [
            'titulo'  => 'Meu perfil',
            'usuario' => $usuario,
        ];

        return view('perfil/index', $dados);
    }

    public function atualizar(): RedirectResponse
    {
        $id = (int) session()->get('usuario_id');

        $validacao = $this->validate([
            'nome'  => 'required|min_length[3]|max_length[120]',
            'email' => 'required|valid_email|is_unique[usuarios.email,id,' . $id . ']',
        ]);

        if (! $validacao) {
            return redirect()->back()->withInput()->with('erros', $this->validator->getErrors());
        }

        $model = new UsuarioModel();

        $model->update($id, [
            'nome'  => $this->request->getPost('nome'),
            'email' => $this->request->getPost('email'),
        ]);

        session()->set('usuario_nome', (string) $this->request->getPost('nome'));

        return redirect()->to('/perfil')->with('sucesso', 'Dados atualizados.');
    }

    public function senha(): string
    {
        $dados = ['titulo' => 'Alterar senha'];

        return view('perfil/senha', $dados);
    }

    public function salvarSenha(): RedirectResponse
    {
        $validacao = $this->validate([
            'senha_atual'          => 'required',
            'nova_senha'           => 'required|min_length[6]',
            'confirmar_nova_senha' => 'required|matches[nova_senha]',
        ]);

        if (! $validacao) {
            return redirect()->back()->with('erros', $this->validator->getErrors());
        }

        $model = new UsuarioModel();
        $usuario = $model->find(session()->get('usuario_id'));

        if (! $usuario || ! password_verify((string) $this->request->getPost('senha_atual'), $usuario['senha'])) {
            return redirect()->back()->with('erro', 'A senha atual esta incorreta.');
        }

        $model->update($usuario['id'], [
            'senha' => password_hash((string) $this->request->getPost('nova_senha'), PASSWORD_DEFAULT),
        ]);

        return redirect()->to('/perfil')->with('sucesso', 'Senha alterada com sucesso.');
    }
}