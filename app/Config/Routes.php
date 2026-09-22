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