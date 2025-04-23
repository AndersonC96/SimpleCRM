<?php
    namespace App\Controller;
    use App\Core\View;
    use App\Config\Database;
    class UsuarioController {
        private \PDO $pdo;
        public function __construct() {
            if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
                header("Location: index.php?url=login");
                exit;
            }
            $this->pdo = \App\Config\Database::connect();
        }
        /*public function index() {
            $stmt = $this->pdo->query("SELECT id, nome, email, tipo, ativo FROM users ORDER BY nome");
            $usuarios = $stmt->fetchAll();
            View::render('usuarios/index', ['usuarios' => $usuarios]);
        }*/

        public function index() {
            $stmt = $this->pdo->query("SELECT id, nome, email, tipo, ativo, criado_em FROM users ORDER BY nome");
            $usuarios = $stmt->fetchAll();
        
            // Cards de resumo
            $total = count($usuarios);
            $ativos = count(array_filter($usuarios, fn($u) => $u['ativo']));
            $recentes = count(array_filter($usuarios, fn($u) => strtotime($u['criado_em']) >= strtotime('-30 days')));
        
            View::render('usuarios/index', [
                'usuarios' => $usuarios,
                'resumo' => [
                    'total' => $total,
                    'ativos' => $ativos,
                    'recentes' => $recentes
                ]
            ]);
        }

        /*public function create() {
            View::render('usuarios/create');
        }*/

        public function create() {
            $csrf_token = bin2hex(random_bytes(32));
            $_SESSION['csrf_token'] = $csrf_token;
        
            View::render('usuarios/create', [
                'csrf_token' => $csrf_token
            ]);
        } 

        public function store() {
            $nome = trim($_POST['nome'] ?? '');
            $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
            $senha = $_POST['senha'] ?? '';
            $tipo = $_POST['tipo'] ?? 'operador';
            $ativo = isset($_POST['ativo']) ? 1 : 0;
            $avatarPath = null;
            if (!empty($_FILES['avatar']['tmp_name'])) {
                $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
                $filename = uniqid('avatar_') . '.' . $ext;
                $destino = 'public/uploads/avatars/' . $filename;
                // Cria o diretório se não existir
                if (!is_dir('public/uploads/avatars')) {
                    mkdir('public/uploads/avatars', 0755, true);
                }
                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $destino)) {
                    $avatarPath = $destino;
                }
            }
            if ($_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
                die('CSRF token inválido.');
            }
            unset($_SESSION['csrf_token']);
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
            $stmt = $this->pdo->prepare("INSERT INTO users (nome, email, senha, avatar, tipo, ativo) VALUES (:nome, :email, :senha, :avatar, :tipo, :ativo)");
            $stmt->execute([
                'nome' => $nome,
                'email' => $email,
                'senha' => password_hash($senha, PASSWORD_DEFAULT),
                'avatar' => $avatarPath,
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
        /*public function update() {
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
        }*/
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
        
            // Lógica para upload da imagem (se enviada)
            $avatarPath = null;
            if (!empty($_FILES['avatar']['name'])) {
                $uploadDir = 'public/uploads/avatars/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
                $filename = uniqid('avatar_') . '.' . $ext;
                $path = $uploadDir . $filename;
        
                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $path)) {
                    $avatarPath = $path;
                }
            }
        
            // Atualiza os dados do usuário
            $sql = "UPDATE users SET nome = :nome, email = :email, tipo = :tipo, ativo = :ativo";
            $params = [
                'nome' => $nome,
                'email' => $email,
                'tipo' => $tipo,
                'ativo' => $ativo,
                'id' => $id
            ];
        
            // Se nova imagem foi enviada, inclui no update
            if ($avatarPath) {
                $sql .= ", avatar = :avatar";
                $params['avatar'] = $avatarPath;
            }
        
            $sql .= " WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
        
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