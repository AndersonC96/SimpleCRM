<?php
    return [
        'GET' => [
            'login'                 => 'AuthController@login',
            'logout'                => 'AuthController@logout',
            'dashboard'             => 'DashboardController@index',
            // 👇 Rotas para o módulo de usuários
            'usuarios'              => 'UsuarioController@index',
            'usuarios/create'       => 'UsuarioController@create',
            'usuarios/edit'         => 'UsuarioController@edit',
            'usuarios/delete'       => 'UsuarioController@delete',
            // 👇 Rotas para o módulo de representantes
            'representantes'        => 'RepresentanteController@index',
            'representantes/create' => 'RepresentanteController@create',
            'representantes/edit'   => 'RepresentanteController@edit',
            'representantes/delete' => 'RepresentanteController@delete',
        ],
        'POST' => [
            'login'                 => 'AuthController@auth',
            // 👇 Salvar novo usuário
            'usuarios/store'        => 'UsuarioController@store',
            'usuarios/update'       => 'UsuarioController@update',
            // 👇 Salvar novo representante
            'representantes/store' => 'RepresentanteController@store',
            'representantes/update' => 'RepresentanteController@update',
            'representantes/delete' => 'RepresentanteController@delete',
        ]
    ];