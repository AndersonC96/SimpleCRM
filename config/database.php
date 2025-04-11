<?php
    use Illuminate\Database\Capsule\Manager as Capsule;
    // Carrega variáveis do .env
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
    // Configura conexão
    $capsule = new Capsule;
    $capsule->addConnection([
        'driver'    => $_ENV['DB_CONNECTION'],
        'host'      => $_ENV['DB_HOST'],
        'port'      => $_ENV['DB_PORT'],
        'database'  => $_ENV['DB_DATABASE'],
        'username'  => $_ENV['DB_USERNAME'],
        'password'  => $_ENV['DB_PASSWORD'],
        'charset'   => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix'    => '',
    ]);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();