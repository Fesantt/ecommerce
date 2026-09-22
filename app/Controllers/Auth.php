<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\HTTP\RedirectResponse;

class Auth extends BaseController
{
    public function cadastro(): string|RedirectResponse
    {
        if (session()->get('usuario_id')) {
            return redirect()->to('/');
        }

        $dados = ['titulo' => 'Criar conta'];

        return view('auth/cadastro', $dados);
    }

    public function salvarCadastro(): RedirectResponse
    {
        $validacao = $this->validate([
            'nome'            => 'required|min_length[3]|max_length[120]',
            'email'           => 'required|valid_email|is_unique[usuarios.email]',
            'senha'           => 'required|min_length[6]',
            'confirmar_senha' => 'required|matches[senha]',
        ]);

        if (! $validacao) {
            return redirect()->back()->withInput()->with('erros', $this->validator->getErrors());
        }

        $model = new UsuarioModel();

        $model->insert([
            'nome'   => $this->request->getPost('nome'),
            'email'  => $this->request->getPost('email'),
            'senha'  => password_hash((string) $this->request->getPost('senha'), PASSWORD_DEFAULT),
            'perfil' => 'cliente',
            'ativo'  => 1,
        ]);

        $usuario = $model->where('email', $this->request->getPost('email'))->first();
        $this->loginEmSessao($usuario);

        return redirect()->to('/')->with('sucesso', 'Conta criada e login realizado.');
    }

    public function login(): string|RedirectResponse
    {
        if (session()->get('usuario_id')) {
            return redirect()->to('/');
        }

        $dados = ['titulo' => 'Entrar'];

        return view('auth/login', $dados);
    }

    public function salvarLogin(): RedirectResponse
    {
        $validacao = $this->validate([
            'email'  => 'required|valid_email',
            'senha'  => 'required',
        ]);

        if (! $validacao) {
            return redirect()->back()->withInput()->with('erros', $this->validator->getErrors());
        }

        $model  = new UsuarioModel();
        $usuario = $model->where('email', $this->request->getPost('email'))->first();

        if (! $usuario || ! password_verify((string) $this->request->getPost('senha'), $usuario['senha'])) {
            return redirect()->back()->withInput()->with('erro', 'Email ou senha incorretos.');
        }

        if ((int) $usuario['ativo'] !== 1) {
            return redirect()->back()->withInput()->with('erro', 'Sua conta esta desativada. Contate o administrador.');
        }

        $this->loginEmSessao($usuario);

        return redirect()->to('/')->with('sucesso', 'Bem-vindo de volta.');
    }

    public function logout(): RedirectResponse
    {
        session()->destroy();

        return redirect()->to('/')->with('sucesso', 'Sessao encerrada.');
    }

    public function trocarSenha(): string
    {
        $dados = ['titulo' => 'Trocar senha'];

        return view('auth/senha', $dados);
    }

    public function salvarSenha(): RedirectResponse
    {
        $validacao = $this->validate([
            'senha_atual'         => 'required',
            'nova_senha'          => 'required|min_length[6]',
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

        return redirect()->to('/')->with('sucesso', 'Senha alterada com sucesso.');
    }

    private function loginEmSessao(array $usuario): void
    {
        session()->set([
            'usuario_id'    => $usuario['id'],
            'usuario_nome'  => $usuario['nome'],
            'perfil'        => $usuario['perfil'],
        ]);
    }
}