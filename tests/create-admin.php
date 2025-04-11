<?php
    require __DIR__ . '/../vendor/autoload.php';
    require __DIR__ . '/../config/database.php';
    use Tisim\SimpleCrm\Models\User;
    $user = new User;
    $user->name = 'Admin Teste';
    $user->email = 'admin@teste.com';
    $user->password = password_hash('admin123', PASSWORD_DEFAULT);
    $user->save();
    echo "✅ Usuário admin criado com sucesso! ID: {$user->id}\n";