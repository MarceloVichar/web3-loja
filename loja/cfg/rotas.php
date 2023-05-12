<?php

$rotas = [
    '/' => [
        'GET' => '\Controlador\RaizControlador#index',
    ],
    '/login' => [
        'GET' => '\Controlador\LoginControlador#criar',
        'POST' => '\Controlador\LoginControlador#armazenar',
        'DELETE' => '\Controlador\LoginControlador#destruir',
    ],
    '/usuarios' => [
        'POST' => '\Controlador\UsuarioControlador#armazenar',
    ],
    '/usuarios/criar' => [
        'GET' => '\Controlador\UsuarioControlador#criar',
    ],
    '/usuarios/sucesso' => [
        'GET' => '\Controlador\UsuarioControlador#sucesso',
    ],
    '/ofertas' => [
        'GET' => '\Controlador\OfertaControlador#index',
    ],
    '/ofertas/criar' => [
        'GET' => '\Controlador\OfertaControlador#criar',
        'POST' => '\Controlador\OfertaControlador#armazenar'
    ],
    '/ofertas/vendas' => [
        'GET' => '\Controlador\OfertaControlador#vendas',
    ],
    '/ofertas/compras' => [
        'GET' => '\Controlador\OfertaControlador#compras',
    ],
    '/ofertas/ativas' => [
        'GET' => '\Controlador\OfertaControlador#ativas',
    ],
    '/ofertas/?' => [
        'PATCH' => '\Controlador\OfertaControlador#comprar',
        'DELETE' => '\Controlador\OfertaControlador#destruir',
    ],
];
