<?php
    $host = DB_HOST;
    $dbname = DB_NAME;
    $user = DB_USER;
    $pass = DB_PASS;
    $backupFile = __DIR__ . "/../backups/backup_" . date('Y-m-d_H-i-s') . ".sql";
    $command = "mysqldump --host={$host} --user={$user} --password={$pass} {$dbname} > {$backupFile}";
    exec($command, $output, $return_var);
    if ($return_var !== 0) {
        echo "Erro ao realizar backup.";
    } else {
        echo "Backup realizado com sucesso: {$backupFile}";
    }