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
    $routes->get('/', 'Admin\Categorias::index');
    $routes->get('novo', 'Admin\Categorias::novo');
    $routes->post('salvar', 'Admin\Categorias::salvar');
    $routes->get('editar/(:num)', 'Admin\Categorias::editar/$1');
    $routes->post('atualizar/(:num)', 'Admin\Categorias::atualizar/$1');
    $routes->post('excluir/(:num)', 'Admin\Categorias::excluir/$1');
});