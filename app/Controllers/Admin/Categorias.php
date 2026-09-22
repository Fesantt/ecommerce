<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoriaModel;
use CodeIgniter\HTTP\RedirectResponse;

class Categorias extends BaseController
{
    private function viewComMenu(string $view, array $dados): string
    {
        $dados['menuAdmin'] = view('layouts/_menu_admin');

        return view($view, $dados);
    }

    public function index(): string
    {
        $model = new CategoriaModel();

        $dados = [
            'titulo'     => 'Categorias',
            'categorias' => $model->orderBy('nome', 'ASC')->paginate(10),
            'pager'      => $model->pager,
        ];

        return $this->viewComMenu('admin/categorias/index', $dados);
    }

    public function novo(): string
    {
        $dados = [
            'titulo'    => 'Nova categoria',
            'categoria' => null,
        ];

        return $this->viewComMenu('admin/categorias/form', $dados);
    }

    public function salvar(): RedirectResponse
    {
        $model = new CategoriaModel();

        if (! $this->validate([
            'nome'      => 'required|min_length[3]|max_length[100]',
            'descricao' => 'max_length[1000]',
        ])) {
            return redirect()->back()->withInput()->with('erros', $this->validator->getErrors());
        }

        $slug = url_title((string) $this->request->getPost('nome'), '-', true);

        if ($model->where('slug', $slug)->first()) {
            return redirect()->back()->withInput()->with('erro', 'Ja existe uma categoria com este nome.');
        }

        $model->insert([
            'nome'      => $this->request->getPost('nome'),
            'slug'      => $slug,
            'descricao' => $this->request->getPost('descricao'),
        ]);

        return redirect()->to('/admin/categorias')->with('sucesso', 'Categoria cadastrada.');
    }

    public function editar(int $id): string|RedirectResponse
    {
        $categoria = (new CategoriaModel())->find($id);

        if (! $categoria) {
            return redirect()->to('/admin/categorias')->with('erro', 'Categoria não encontrada.');
        }

        $dados = [
            'titulo'    => 'Editar categoria',
            'categoria' => $categoria,
        ];

        return $this->viewComMenu('admin/categorias/form', $dados);
    }

    public function atualizar(int $id): RedirectResponse
    {
        $model = new CategoriaModel();
        $categoria = $model->find($id);

        if (! $categoria) {
            return redirect()->to('/admin/categorias')->with('erro', 'Categoria não encontrada.');
        }

        if (! $this->validate([
            'nome'      => 'required|min_length[3]|max_length[100]',
            'descricao' => 'max_length[1000]',
        ])) {
            return redirect()->back()->withInput()->with('erros', $this->validator->getErrors());
        }

        $slug = url_title((string) $this->request->getPost('nome'), '-', true);
        $outra = $model->where('slug', $slug)->where('id !=', $id)->first();

        if ($outra) {
            return redirect()->back()->withInput()->with('erro', 'Ja existe uma categoria com este nome.');
        }

        $model->update($id, [
            'nome'      => $this->request->getPost('nome'),
            'slug'      => $slug,
            'descricao' => $this->request->getPost('descricao'),
        ]);

        return redirect()->to('/admin/categorias')->with('sucesso', 'Categoria atualizada.');
    }

    public function excluir(int $id): RedirectResponse
    {
        $model = new CategoriaModel();

        if (! $model->find($id)) {
            return redirect()->to('/admin/categorias')->with('erro', 'Categoria não encontrada.');
        }

        $emUso = db_connect()->table('produtos')->where('categoria_id', $id)->countAllResults();

        if ($emUso > 0) {
            return redirect()->to('/admin/categorias')->with('erro', 'Esta categoria possui produtos e não pode ser excluida.');
        }

        $model->delete($id);

        return redirect()->to('/admin/categorias')->with('sucesso', 'Categoria excluida.');
    }
}