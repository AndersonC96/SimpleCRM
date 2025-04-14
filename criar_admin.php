<?php
    require_once __DIR__ . '/vendor/autoload.php';
    use App\Core\Database;
    $nome = 'Administrador';
    $email = 'admin@example.com';
    $senha = 'admin123'; // será criptografada
    $tipo = 'admin';
    $ativo = true;
    try {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("INSERT INTO users (nome, email, senha, tipo, ativo) VALUES (:nome, :email, :senha, :tipo, :ativo)");
        $stmt->execute([
            'nome' => $nome,
            'email' => $email,
            'senha' => password_hash($senha, PASSWORD_DEFAULT),
            'tipo' => $tipo,
            'ativo' => $ativo
        ]);
        echo "✅ Usuário administrador criado com sucesso!\n";
        echo "Login: $email\nSenha: $senha\n";
    } catch (PDOException $e) {
        echo "Erro ao criar usuário: " . $e->getMessage();
    }