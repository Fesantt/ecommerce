<?php

use CodeIgniter\Router\RouteCollection;


$routes->get('/', 'Catalogo::index');
$routes->get('produto/(:segment)', 'Catalogo::detalhe/$1');
$routes->get('categoria/(:segment)', 'Catalogo::categoria/$1');
$routes->get('busca', 'Catalogo::busca');

$routes->get('/cadastro', 'Auth::cadastro');
$routes->post('/cadastro/salvar', 'Auth::salvarCadastro');
$routes->get('/login', 'Auth::login');
$routes->post('/login/salvar', 'Auth::salvarLogin');
$routes->get('/logout', 'Auth::logout');
$routes->get('/conta/senha', 'Auth::trocarSenha', ['filter' => 'auth']);
$routes->post('/conta/senha/salvar', 'Auth::salvarSenha', ['filter' => 'auth']);

$routes->group('admin/categorias', ['filter' => 'admin'], function ($routes) {
    $routes->get('/', 'Admin\Categorias::index');
    $routes->get('novo', 'Admin\Categorias::novo');
    $routes->post('salvar', 'Admin\Categorias::salvar');
    $routes->get('editar/(:num)', 'Admin\Categorias::editar/$1');
    $routes->post('atualizar/(:num)', 'Admin\Categorias::atualizar/$1');
    $routes->post('excluir/(:num)', 'Admin\Categorias::excluir/$1');
});

$routes->group('admin/produtos', ['filter' => 'admin'], function ($routes) {
    $routes->get('/', 'Admin\Produtos::index');
    $routes->get('novo', 'Admin\Produtos::novo');
    $routes->post('salvar', 'Admin\Produtos::salvar');
    $routes->get('editar/(:num)', 'Admin\Produtos::editar/$1');
    $routes->post('atualizar/(:num)', 'Admin\Produtos::atualizar/$1');
    $routes->post('excluir/(:num)', 'Admin\Produtos::excluir/$1');
});