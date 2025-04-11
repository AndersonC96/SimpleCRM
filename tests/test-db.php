<?php
    require __DIR__ . '/../vendor/autoload.php';
    require __DIR__ . '/../config/database.php';
    use Illuminate\Database\Capsule\Manager as DB;
    try {
        DB::connection()->getPdo();
        echo "✅ Banco conectado com sucesso!";
    } catch (Exception $e) {
        echo "❌ Erro na conexão: " . $e->getMessage();
    }
?>