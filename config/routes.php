<?php
    return [
        'GET' => [
            'login'      => 'AuthController@login',
            'dashboard'  => 'DashboardController@index',
            // 👇 Novas rotas para o módulo de usuários
            'usuarios'           => 'UsuarioController@index',
            'usuarios/create'    => 'UsuarioController@create',
        ],
        'POST' => [
            'login'              => 'AuthController@auth',
            // 👇 Para salvar novo usuário
            'usuarios/store'     => 'UsuarioController@store',
        ]
    ];