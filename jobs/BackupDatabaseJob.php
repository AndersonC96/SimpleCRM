<?php
    namespace App\Job;
    class BackupDatabaseJob {
        public function executar(): void {
            $host = $_ENV['DB_HOST'];
            $user = $_ENV['DB_USER'];
            $pass = $_ENV['DB_PASS'];
            $dbname = $_ENV['DB_NAME'];
            $data = date('Ymd_His');
            $arquivo = __DIR__ . "/../backup/backup_{$dbname}_$data.sql";
            if (!is_dir(dirname($arquivo))) {
                mkdir(dirname($arquivo), 0777, true);
            }
            $cmd = "mysqldump -h $host -u $user -p$pass $dbname > \"$arquivo\"";
            system($cmd, $retorno);
            if ($retorno === 0) {
                echo "Backup gerado com sucesso: $arquivo\n";
            } else {
                echo "Erro ao gerar backup (código $retorno).\n";
            }
        }
    }