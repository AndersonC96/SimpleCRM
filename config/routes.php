<?php
    return [
        'GET' => [
            'login' => 'AuthController@login',
            'dashboard' => 'DashboardController@index',
        ],
        'POST' => [
            'login' => 'AuthController@auth',
        ]
    ];