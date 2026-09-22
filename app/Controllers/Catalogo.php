<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Models\ProdutoModel;

class Catalogo extends BaseController
{
    public function index(): string
    {
        $model = new ProdutoModel();

        $dados = [
            'titulo'     => 'Loja Virtual',
            'produtos'   => $model->where('ativo', 1)
                ->orderBy('destaque', 'DESC')
                ->orderBy('id', 'DESC')
                ->paginate(12),
            'pager'      => $model->pager,
            'categorias' => (new CategoriaModel())->orderBy('nome', 'ASC')->findAll(),
        ];

        return view('catalogo/index', $dados);
    }

    public function detalhe(string $slug): string
    {
        $model = new ProdutoModel();
        $produto = $model->where('slug', $slug)->where('ativo', 1)->first();

        if (! $produto) {
            return view('catalogo/nao_encontrado', ['titulo' => 'Produto não encontrado']);
        }

        $dados = [
            'titulo'     => $produto['nome'],
            'produto'    => $produto,
            'categorias' => (new CategoriaModel())->orderBy('nome', 'ASC')->findAll(),
        ];

        return view('catalogo/detalhe', $dados);
    }

    public function categoria(string $slug): string
    {
        $categoria = (new CategoriaModel())->where('slug', $slug)->first();

        if (! $categoria) {
            return view('catalogo/nao_encontrado', ['titulo' => 'Categoria não encontrada']);
        }

        $model = new ProdutoModel();

        $dados = [
            'titulo'     => $categoria['nome'],
            'categoria'  => $categoria,
            'produtos'   => $model->where('ativo', 1)
                ->where('categoria_id', $categoria['id'])
                ->orderBy('id', 'DESC')
                ->paginate(12),
            'pager'      => $model->pager,
            'categorias' => (new CategoriaModel())->orderBy('nome', 'ASC')->findAll(),
        ];

        return view('catalogo/categoria', $dados);
    }

    public function busca(): string
    {
        $termo = trim((string) $this->request->getGet('q'));
        $categoriaId = (int) $this->request->getGet('categoria');

        if ($categoriaId > 0 && ! $this->validate(['categoria' => 'is_not_unique[categorias.id]'])) {
            $categoriaId = 0;
        }

        $model = new ProdutoModel();
        $model->where('ativo', 1);

        if ($termo !== '') {
            $model->groupStart()
                ->like('nome', $termo)
                ->orLike('descricao', $termo)
                ->groupEnd();
        }

        if ($categoriaId > 0) {
            $model->where('categoria_id', $categoriaId);
        }

        $dados = [
            'titulo'       => 'Busca: ' . ($termo !== '' ? $termo : 'todos'),
            'produtos'     => $model->orderBy('id', 'DESC')->paginate(12),
            'pager'        => $model->pager,
            'categorias'   => (new CategoriaModel())->orderBy('nome', 'ASC')->findAll(),
            'busca'        => $termo,
            'categoriaAtual' => $categoriaId,
        ];

        $model->pager->only(['q', 'categoria']);

        return view('catalogo/busca', $dados);
    }
}