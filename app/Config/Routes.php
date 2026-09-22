<?php

use CodeIgniter\Router\RouteCollection;


$routes->get('/', 'Home::index');

$routes->get('/cadastro', 'Auth::cadastro');
$routes->post('/cadastro/salvar', 'Auth::salvarCadastro');
$routes->get('/login', 'Auth::login');
$routes->post('/login/salvar', 'Auth::salvarLogin');
$routes->get('/logout', 'Auth::logout');
$routes->get('/conta/senha', 'Auth::trocarSenha', ['filter' => 'auth']);
$routes->post('/conta/senha/salvar', 'Auth::salvarSenha', ['filter' => 'auth']);

$routes->group('admin/categorias', ['filter' => 'admin'], function ($routes) {
    $routes->get('/', 'Categorias::index');
    $routes->get('novo', 'Categorias::novo');
    $routes->post('salvar', 'Categorias::salvar');
    $routes->get('editar/(:num)', 'Categorias::editar/$1');
    $routes->post('atualizar/(:num)', 'Categorias::atualizar/$1');
    $routes->post('excluir/(:num)', 'Categorias::excluir/$1');
});

$routes->group('admin/produtos', ['filter' => 'admin'], function ($routes) {
    $routes->get('/', 'Produtos::index');
    $routes->get('novo', 'Produtos::novo');
    $routes->post('salvar', 'Produtos::salvar');
    $routes->get('editar/(:num)', 'Produtos::editar/$1');
    $routes->post('atualizar/(:num)', 'Produtos::atualizar/$1');
    $routes->post('excluir/(:num)', 'Produtos::excluir/$1');
});