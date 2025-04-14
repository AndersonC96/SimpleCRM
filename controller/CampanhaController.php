<?php
    namespace App\Controller;
    use App\Core\View;
    use App\Config\Database;
    use App\Service\WhatsAppService;
    class CampanhaController {
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
            $stmt = $this->pdo->query("SELECT c.*, t.nome AS template FROM campanhas c LEFT JOIN templates t ON c.template_id = t.id ORDER BY c.data_inicio DESC");
            $campanhas = $stmt->fetchAll();
            View::render('campanhas/index', ['campanhas' => $campanhas]);
        }
        public function criar() {
            $templates = $this->pdo->query("SELECT id, nome FROM templates")->fetchAll();
            $clientes = $this->pdo->query("SELECT id, nome FROM clientes ORDER BY nome")->fetchAll();
            View::render('campanhas/criar', [
                'templates' => $templates,
                'clientes' => $clientes
            ]);
        }
        public function salvar() {
            $nome = trim($_POST['nome'] ?? '');
            $template_id = $_POST['template_id'] ?? null;
            $canal = $_POST['canal'] ?? 'whatsapp';
            $data_inicio = $_POST['data_inicio'] ?? date('Y-m-d');
            $clientes_ids = $_POST['clientes'] ?? [];
            if (!$nome || !$template_id || empty($clientes_ids)) {
                echo "Preencha todos os campos obrigatórios.";
                return;
            }
            // Cria campanha
            $stmt = $this->pdo->prepare("INSERT INTO campanhas (nome, data_inicio, template_id, canal, status) VALUES (:nome, :data_inicio, :template_id, :canal, 'agendada')");
            $stmt->execute([
                'nome' => $nome,
                'data_inicio' => $data_inicio,
                'template_id' => $template_id,
                'canal' => $canal
            ]);
            $campanha_id = $this->pdo->lastInsertId();
            // Associa clientes à campanha
            $stmtAssoc = $this->pdo->prepare("INSERT INTO campanha_clientes (campanha_id, cliente_id, agendado_para, status) VALUES (:campanha_id, :cliente_id, :agendado_para, 'pendente')");
            foreach ($clientes_ids as $cliente_id) {
                $stmtAssoc->execute([
                    'campanha_id' => $campanha_id,
                    'cliente_id' => $cliente_id,
                    'agendado_para' => $data_inicio
                ]);
            }
            header("Location: index.php?url=campanhas");
        }
        public function disparar() {
            $id = $_GET['id'] ?? null;
            if (!$id) {
                echo "Campanha inválida.";
                return;
            }
            // Pega campanha e template
            $stmt = $this->pdo->prepare("SELECT c.*, t.conteudo_html FROM campanhas c JOIN templates t ON c.template_id = t.id WHERE c.id = :id");
            $stmt->execute(['id' => $id]);
            $campanha = $stmt->fetch();
            if (!$campanha) {
                echo "Campanha não encontrada.";
                return;
            }
            // Pega clientes da campanha
            $stmt = $this->pdo->prepare("SELECT cc.id AS cc_id, cl.nome, cl.telefone FROM campanha_clientes cc JOIN clientes cl ON cc.cliente_id = cl.id WHERE cc.campanha_id = :id AND cc.status = 'pendente'");
            $stmt->execute(['id' => $id]);
            $destinatarios = $stmt->fetchAll();
            $whats = new WhatsAppService();
            foreach ($destinatarios as $dest) {
                $mensagem = str_replace('{nome}', $dest['nome'], $campanha['conteudo_html']);
                $res = $whats->enviarMensagem($dest['telefone'], $mensagem);
                $status = $res['success'] ? 'enviado' : 'falha';
                $update = $this->pdo->prepare("UPDATE campanha_clientes SET status = :status, enviado_em = NOW() WHERE id = :id");
                $update->execute([
                    'status' => $status,
                    'id' => $dest['cc_id']
                ]);
            }
            // Atualiza status da campanha
            $this->pdo->prepare("UPDATE campanhas SET status = 'finalizada' WHERE id = :id")
                  ->execute(['id' => $id]);
            header("Location: index.php?url=campanhas");
        }
        public function status() {
            $id = $_GET['id'] ?? null;
            if (!$id) {
                echo "Campanha inválida.";
                return;
            }
            $stmt = $this->pdo->prepare("SELECT cl.nome, cl.telefone, cc.status, cc.enviado_em FROM campanha_clientes cc JOIN clientes cl ON cl.id = cc.cliente_id WHERE cc.campanha_id = :id");
            $stmt->execute(['id' => $id]);
            $dados = $stmt->fetchAll();
            View::render('campanhas/status', ['envios' => $dados]);
        }
    }