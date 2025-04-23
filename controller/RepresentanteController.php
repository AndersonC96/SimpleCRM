<?php
    namespace App\Controller;
    use App\Core\View;
    use App\Config\Database;
   
    class RepresentanteController {
        private \PDO $pdo;  
        public function __construct() {
            $this->pdo = Database::connect();
        }
        public function index() {
            $stmt = $this->pdo->query("SELECT * FROM representantes ORDER BY nome");
            $representantes = $stmt->fetchAll();
            View::render('representantes/index', ['representantes' => $representantes]);
        }
        public function create() {
            View::render('representantes/create');
        }
        public function store() {
            $nome = $_POST['nome'] ?? '';
            $area = $_POST['area_atuacao'] ?? '';
            $stmt = $this->pdo->prepare("INSERT INTO representantes (nome, area_atuacao) VALUES (:nome, :area)");
            $stmt->execute(['nome' => $nome, 'area' => $area]);
            header("Location: index.php?url=representantes");
        }
        public function edit() {
            $id = $_GET['id'] ?? null;
            $stmt = $this->pdo->prepare("SELECT * FROM representantes WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $representante = $stmt->fetch();
            View::render('representantes/edit', ['representante' => $representante]);
        }
        public function update() {
            $id = $_POST['id'];
            $nome = $_POST['nome'];
            $area = $_POST['area_atuacao'];
            $stmt = $this->pdo->prepare("UPDATE representantes SET nome = :nome, area_atuacao = :area WHERE id = :id");
            $stmt->execute(['nome' => $nome, 'area' => $area, 'id' => $id]);
            header("Location: index.php?url=representantes");
        }
        public function delete() {
            $id = $_GET['id'];
            $stmt = $this->pdo->prepare("DELETE FROM representantes WHERE id = :id");
            $stmt->execute(['id' => $id]);
            header("Location: index.php?url=representantes");
        }
    }    