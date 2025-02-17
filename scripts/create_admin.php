<?php
    // Carrega as configurações e o autoload (se estiver usando Composer)
    // Usando __DIR__ para obter o caminho absoluto do diretório atual e voltar um nível
    require_once __DIR__ . '/../config/config.php';
    // Inclui o modelo User
    require_once __DIR__ . '/../app/models/User.php';
    // Inicia a sessão, se necessário
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Defina os dados do usuário administrador para teste
    $username = 'admin';
    $email = 'admin@example.com';
    $password = 'admin123';
    // Criptografa a senha utilizando o password_hash
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    // Verifica se o usuário admin já existe (baseado no username)
    if (User::exists($username)) {
        echo "Usuário admin já existe.";
    } else {
        // Cria o usuário admin
        $id = User::create($username, $email, $passwordHash);
        if ($id) {
            echo "Usuário admin criado com sucesso. ID: " . htmlspecialchars($id);
        } else {
            echo "Falha ao criar o usuário admin.";
        }
    }