<?php
    namespace App\Job;
    use App\Config\Database;
    use PhpOffice\PhpSpreadsheet\IOFactory;
    class ImportacaoAutomaticaJob {
        public function executar(): void {
            $arquivo = __DIR__ . '/../importar/clientes.xlsx';
            if (!file_exists($arquivo)) {
                echo "Arquivo não encontrado: clientes.xlsx\n";
                return;
            }
            $pdo = Database::connect();
            $spreadsheet = IOFactory::load($arquivo);
            $dados = $spreadsheet->getActiveSheet()->toArray();
            foreach ($dados as $index => $linha) {
                if ($index === 0) continue; // cabeçalho
                [$nome, $telefone, $email, $tags] = $linha;
                $telefone = preg_replace('/\D/', '', $telefone);
                if (strlen($telefone) < 8 || !$nome) continue;
                // Evita duplicados
                $stmt = $pdo->prepare("SELECT id FROM clientes WHERE telefone = :tel");
                $stmt->execute(['tel' => $telefone]);
                if ($stmt->fetch()) continue;
                $stmt = $pdo->prepare("INSERT INTO clientes (nome, telefone, email, tags) VALUES (:nome, :telefone, :email, :tags)");
                $stmt->execute([
                    'nome' => trim($nome),
                    'telefone' => $telefone,
                    'email' => filter_var($email, FILTER_VALIDATE_EMAIL),
                    'tags' => trim($tags)
                ]);
            }
            echo "Importação automática concluída.\n";
        }
    }