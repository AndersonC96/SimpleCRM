<?php
    namespace App\Controller;
    use App\Core\View;
    use App\Config\Database;
    use PhpOffice\PhpSpreadsheet\IOFactory;
    class ClienteController {
        private \PDO $pdo;
        public function __construct() {
            session_start();
            if (!isset($_SESSION['usuario'])) {
                header("Location: index.php?url=login");
                exit;
            }
            $this->pdo = Database::connect();
        }
        public function index() {
            $stmt = $this->pdo->query("SELECT c.*, r.nome AS representante FROM clientes c
                LEFT JOIN representantes r ON c.representante_id = r.id
                ORDER BY c.nome");
            $clientes = $stmt->fetchAll();
            View::render('clientes/index', ['clientes' => $clientes]);
        }
        public function criar() {
            $representantes = $this->pdo->query("SELECT id, nome FROM representantes")->fetchAll();
            View::render('clientes/criar', ['representantes' => $representantes]);
        }
        public function salvar() {
            $nome = trim($_POST['nome'] ?? '');
            $telefone = preg_replace('/\D/', '', $_POST['telefone'] ?? '');
            $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
            $tags = trim($_POST['tags'] ?? '');
            $representante_id = $_POST['representante_id'] ?? null;
            if (!$nome || strlen($telefone) < 8) {
                echo "Nome e telefone são obrigatórios.";
                return;
            }
            // Verifica duplicidade
            $stmt = $this->pdo->prepare("SELECT id FROM clientes WHERE telefone = :tel OR email = :email");
            $stmt->execute(['tel' => $telefone, 'email' => $email]);
            if ($stmt->fetch()) {
                echo "Cliente já cadastrado.";
                return;
            }
            $stmt = $this->pdo->prepare("INSERT INTO clientes (nome, telefone, email, tags, representante_id) VALUES (:nome, :telefone, :email, :tags, :representante_id)");
            $stmt->execute([
                'nome' => $nome,
                'telefone' => $telefone,
                'email' => $email,
                'tags' => $tags,
                'representante_id' => $representante_id
            ]);
            header("Location: index.php?url=clientes");
        }
        public function editar() {
            $id = $_GET['id'] ?? null;
            if (!$id) {
                echo "ID inválido.";
                return;
            }
            $stmt = $this->pdo->prepare("SELECT * FROM clientes WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $cliente = $stmt->fetch();
            if (!$cliente) {
                echo "Cliente não encontrado.";
                return;
            }
            $representantes = $this->pdo->query("SELECT id, nome FROM representantes")->fetchAll();
            View::render('clientes/editar', ['cliente' => $cliente, 'representantes' => $representantes]);
        }
        public function atualizar() {
            $id = $_POST['id'] ?? null;
            $nome = trim($_POST['nome'] ?? '');
            $telefone = preg_replace('/\D/', '', $_POST['telefone'] ?? '');
            $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
            $tags = trim($_POST['tags'] ?? '');
            $representante_id = $_POST['representante_id'] ?? null;
            if (!$id || !$nome || strlen($telefone) < 8) {
                echo "Dados inválidos.";
                return;
            }
            $stmt = $this->pdo->prepare("UPDATE clientes SET nome = :nome, telefone = :telefone, email = :email, tags = :tags, representante_id = :representante_id WHERE id = :id");
            $stmt->execute([
                'id' => $id,
                'nome' => $nome,
                'telefone' => $telefone,
                'email' => $email,
                'tags' => $tags,
                'representante_id' => $representante_id
            ]);
            header("Location: index.php?url=clientes");
        }
        public function excluir() {
            $id = $_GET['id'] ?? null;
            if (!$id) {
                echo "ID inválido.";
                return;
            }
            $stmt = $this->pdo->prepare("DELETE FROM clientes WHERE id = :id");
            $stmt->execute(['id' => $id]);
            header("Location: index.php?url=clientes");
        }
        public function importar() {
            if (!isset($_FILES['arquivo']) || $_FILES['arquivo']['error'] !== UPLOAD_ERR_OK) {
                echo "Erro no upload do arquivo.";
                return;
            }
            $planilha = IOFactory::load($_FILES['arquivo']['tmp_name']);
            $sheet = $planilha->getActiveSheet();
            $dados = $sheet->toArray();
            foreach ($dados as $index => $linha) {
                if ($index === 0) continue; // Ignora cabeçalho
                [$nome, $telefone, $email, $tags] = $linha;
                $telefone = preg_replace('/\D/', '', $telefone);
                if (strlen($telefone) < 8 || !$nome) continue;
                $stmt = $this->pdo->prepare("SELECT id FROM clientes WHERE telefone = :telefone");
                $stmt->execute(['telefone' => $telefone]);
                if ($stmt->fetch()) continue; // Já existe
                $stmt = $this->pdo->prepare("INSERT INTO clientes (nome, telefone, email, tags) VALUES (:nome, :telefone, :email, :tags)");
                $stmt->execute([
                    'nome' => trim($nome),
                    'telefone' => $telefone,
                    'email' => filter_var($email, FILTER_VALIDATE_EMAIL),
                    'tags' => trim($tags)
                ]);
            }
            header("Location: index.php?url=clientes");
        }
        public function exportar() {
            header("Content-Type: text/csv");
            header("Content-Disposition: attachment;filename=clientes.csv");
            $stmt = $this->pdo->query("SELECT nome, telefone, email, tags FROM clientes");
            $clientes = $stmt->fetchAll();
            $f = fopen('php://output', 'w');
            fputcsv($f, ['Nome', 'Telefone', 'Email', 'Tags']);
            foreach ($clientes as $cliente) {
                fputcsv($f, $cliente);
            }
            fclose($f);
        }
    }