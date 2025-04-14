<?php
    namespace App\Controller;
    use App\Core\View;
    use App\Config\Database;
    class UsuarioController {
        private PDO $pdo;
        public function __construct() {
            session_start();
            if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
                header("Location: index.php?url=login");
                exit;
            }
            $this->pdo = \App\Config\Database::connect();
        }
        public function index() {
            $stmt = $this->pdo->query("SELECT id, nome, email, tipo, ativo FROM users ORDER BY nome");
            $usuarios = $stmt->fetchAll();
            View::render('usuarios/index', ['usuarios' => $usuarios]);
        }
        public function create() {
            View::render('usuarios/create');
        }
        public function store() {
            $nome = trim($_POST['nome'] ?? '');
            $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
            $senha = $_POST['senha'] ?? '';
            $tipo = $_POST['tipo'] ?? 'operador';
            $ativo = isset($_POST['ativo']) ? 1 : 0;
            if (!$nome || !$email || strlen($senha) < 6) {
                echo "Dados inválidos.";
                return;
            }
            // Verifica duplicidade
            $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            if ($stmt->fetch()) {
                echo "E-mail já cadastrado.";
                return;
            }
            // Insere no banco
            $stmt = $this->pdo->prepare("INSERT INTO users (nome, email, senha, tipo, ativo) VALUES (:nome, :email, :senha, :tipo, :ativo)");
            $stmt->execute([
                'nome' => $nome,
                'email' => $email,
                'senha' => password_hash($senha, PASSWORD_DEFAULT),
                'tipo' => $tipo,
                'ativo' => $ativo
            ]);
            header("Location: index.php?url=usuarios");
        }
        public function edit() {
            $id = $_GET['id'] ?? null;
            if (!$id) {
                echo "ID inválido.";
                return;
            }
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $usuario = $stmt->fetch();
            if (!$usuario) {
                echo "Usuário não encontrado.";
                return;
            }
            View::render('usuarios/edit', ['usuario' => $usuario]);
        }
        public function update() {
            $id = $_POST['id'] ?? null;
            $nome = trim($_POST['nome'] ?? '');
            $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
            $tipo = $_POST['tipo'] ?? 'operador';
            $ativo = isset($_POST['ativo']) ? 1 : 0;
            if (!$id || !$nome || !$email) {
                echo "Dados inválidos.";
                return;
            }
            // Atualiza dados
            $stmt = $this->pdo->prepare("UPDATE users SET nome = :nome, email = :email, tipo = :tipo, ativo = :ativo WHERE id = :id");
            $stmt->execute([
                'nome' => $nome,
                'email' => $email,
                'tipo' => $tipo,
                'ativo' => $ativo,
                'id' => $id
            ]);
            header("Location: index.php?url=usuarios");
        }
        public function delete() {
            $id = $_GET['id'] ?? null;
            if (!$id) {
                echo "ID inválido.";
                return;
            }
            $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
            $stmt->execute(['id' => $id]);
            header("Location: index.php?url=usuarios");
        }
    }