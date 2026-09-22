<?php

use CodeIgniter\Router\RouteCollection;


$routes->get('/', 'Catalogo::index');
$routes->get('produto/(:segment)', 'Catalogo::detalhe/$1');
$routes->get('categoria/(:segment)', 'Catalogo::categoria/$1');
$routes->get('busca', 'Catalogo::busca');

$routes->get('/carrinho', 'Carrinho::index');
$routes->post('/carrinho/adicionar', 'Carrinho::adicionar');
$routes->post('/carrinho/atualizar/(:num)', 'Carrinho::atualizar/$1');
$routes->post('/carrinho/remover/(:num)', 'Carrinho::remover/$1');

$routes->get('/checkout', 'Checkout::index', ['filter' => 'auth']);
$routes->post('/checkout/confirmar', 'Checkout::confirmar', ['filter' => 'auth']);
$routes->get('/checkout/sucesso/(:num)', 'Checkout::sucesso/$1', ['filter' => 'auth']);
$routes->get('/meus-pedidos', 'Pedidos::index', ['filter' => 'auth']);
$routes->get('/meus-pedidos/(:num)', 'Pedidos::detalhe/$1', ['filter' => 'auth']);

$routes->get('/perfil', 'Perfil::index', ['filter' => 'auth']);
$routes->post('/perfil/atualizar', 'Perfil::atualizar', ['filter' => 'auth']);
$routes->get('/perfil/senha', 'Perfil::senha', ['filter' => 'auth']);
$routes->post('/perfil/senha/salvar', 'Perfil::salvarSenha', ['filter' => 'auth']);

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

$routes->group('admin/usuarios', ['filter' => 'admin'], function ($routes) {
    $routes->get('/', 'Usuarios::index');
    $routes->get('novo', 'Usuarios::novo');
    $routes->post('salvar', 'Usuarios::salvar');
    $routes->get('editar/(:num)', 'Usuarios::editar/$1');
    $routes->post('atualizar/(:num)', 'Usuarios::atualizar/$1');
    $routes->post('desativar/(:num)', 'Usuarios::desativar/$1');
    $routes->post('ativar/(:num)', 'Usuarios::ativar/$1');
});

$routes->group('admin/pedidos', ['filter' => 'admin'], function ($routes) {
    $routes->get('/', 'Pedidos::index');
    $routes->get('detalhe/(:num)', 'Pedidos::detalhe/$1');
    $routes->post('status/(:num)', 'Pedidos::status/$1');
});

$routes->get('/admin', 'Dashboard::index', ['filter' => 'admin']);