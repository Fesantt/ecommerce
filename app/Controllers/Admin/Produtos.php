<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoriaModel;
use App\Models\ProdutoModel;
use CodeIgniter\HTTP\RedirectResponse;

class Produtos extends BaseController
{
    private function viewComMenu(string $view, array $dados): string
    {
        $dados['menuAdmin'] = view('layouts/_menu_admin');

        return view($view, $dados);
    }

    public function index(): string
    {
        $model = new ProdutoModel();
        $model->comCategoria();

        $busca  = (string) $this->request->getGet('q');
        $categoriaId = (int) $this->request->getGet('categoria');

        if ($busca !== '') {
            $model->like('produtos.nome', $busca);
        }

        if ($categoriaId > 0) {
            $model->where('produtos.categoria_id', $categoriaId);
        }

        $dados = [
            'titulo'     => 'Produtos',
            'produtos'   => $model->orderBy('produtos.id', 'DESC')->paginate(10),
            'pager'      => $model->pager,
            'categorias' => (new CategoriaModel())->orderBy('nome', 'ASC')->findAll(),
            'busca'      => $busca,
            'categoriaAtual' => $categoriaId,
        ];

        return $this->viewComMenu('admin/produtos/index', $dados);
    }

    public function novo(): string
    {
        $dados = [
            'titulo'     => 'Novo produto',
            'produto'    => null,
            'categorias' => (new CategoriaModel())->orderBy('nome', 'ASC')->findAll(),
        ];

        return $this->viewComMenu('admin/produtos/form', $dados);
    }

    public function salvar(): RedirectResponse
    {
        if (! $this->validarFormulario()) {
            return redirect()->back()->withInput()->with('erros', $this->validator->getErrors());
        }

        $model = new ProdutoModel();
        $slug = url_title((string) $this->request->getPost('nome'), '-', true);

        if ($model->where('slug', $slug)->first()) {
            return redirect()->back()->withInput()->with('erro', 'Ja existe um produto com este nome.');
        }

        $model->insert([
            'categoria_id' => $this->request->getPost('categoria_id'),
            'nome'         => $this->request->getPost('nome'),
            'slug'         => $slug,
            'descricao'    => $this->request->getPost('descricao'),
            'preco'        => $this->request->getPost('preco'),
            'quantidade'   => $this->request->getPost('quantidade'),
            'imagem'       => $this->salvarImagem(),
            'destaque'     => $this->request->getPost('destaque') ? 1 : 0,
            'ativo'        => $this->request->getPost('ativo') ? 1 : 0,
        ]);

        return redirect()->to('/admin/produtos')->with('sucesso', 'Produto cadastrado.');
    }

    public function editar(int $id): string|RedirectResponse
    {
        $produto = (new ProdutoModel())->find($id);

        if (! $produto) {
            return redirect()->to('/admin/produtos')->with('erro', 'Produto não encontrado.');
        }

        $dados = [
            'titulo'     => 'Editar produto',
            'produto'    => $produto,
            'categorias' => (new CategoriaModel())->orderBy('nome', 'ASC')->findAll(),
        ];

        return $this->viewComMenu('admin/produtos/form', $dados);
    }

    public function atualizar(int $id): RedirectResponse
    {
        $model = new ProdutoModel();
        $produto = $model->find($id);

        if (! $produto) {
            return redirect()->to('/admin/produtos')->with('erro', 'Produto não encontrado.');
        }

        if (! $this->validarFormulario($id)) {
            return redirect()->back()->withInput()->with('erros', $this->validator->getErrors());
        }

        $slug = url_title((string) $this->request->getPost('nome'), '-', true);
        $outro = $model->where('slug', $slug)->where('id !=', $id)->first();

        if ($outro) {
            return redirect()->back()->withInput()->with('erro', 'Ja existe um produto com este nome.');
        }

        $imagem = $this->salvarImagem();

        if ($imagem && $produto['imagem']) {
            $this->removerImagem($produto['imagem']);
        }

        $model->update($id, [
            'categoria_id' => $this->request->getPost('categoria_id'),
            'nome'         => $this->request->getPost('nome'),
            'slug'         => $slug,
            'descricao'    => $this->request->getPost('descricao'),
            'preco'        => $this->request->getPost('preco'),
            'quantidade'   => $this->request->getPost('quantidade'),
            'imagem'       => $imagem ?: $produto['imagem'],
            'destaque'     => $this->request->getPost('destaque') ? 1 : 0,
            'ativo'        => $this->request->getPost('ativo') ? 1 : 0,
        ]);

        return redirect()->to('/admin/produtos')->with('sucesso', 'Produto atualizado.');
    }

    public function excluir(int $id): RedirectResponse
    {
        $model = new ProdutoModel();
        $produto = $model->find($id);

        if (! $produto) {
            return redirect()->to('/admin/produtos')->with('erro', 'Produto não encontrado.');
        }

        if ($produto['imagem']) {
            $this->removerImagem($produto['imagem']);
        }

        $model->delete($id);

        return redirect()->to('/admin/produtos')->with('sucesso', 'Produto excluido.');
    }

    private function validarFormulario(int $id = 0): bool
    {
        $regras = [
            'categoria_id' => 'required|is_not_unique[categorias.id]',
            'nome'         => 'required|min_length[3]|max_length[150]',
            'preco'        => 'required|decimal|greater_than[0]',
            'quantidade'   => 'required|integer|greater_than_equal_to[0]',
        ];

        if ($this->request->getFile('imagem') && $this->request->getFile('imagem')->getName() !== '') {
            $regras['imagem'] = 'is_image[imagem]|max_size[imagem,2048]';
        }

        return $this->validate($regras);
    }

    private function salvarImagem(): ?string
    {
        $arquivo = $this->request->getFile('imagem');

        if (! $arquivo || ! $arquivo->isValid()) {
            return null;
        }

        $nome = $arquivo->getRandomName();
        $arquivo->move(FCPATH . 'uploads', $nome);

        return $nome;
    }

    private function removerImagem(string $nome): void
    {
        $caminho = FCPATH . 'uploads/' . $nome;

        if (is_file($caminho)) {
            unlink($caminho);
        }
    }
}