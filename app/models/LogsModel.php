<?php
    class LogsModel {
        /**
        * Retorna os logs/histórico de atividades.
        *
        * Opcionalmente, filtra os logs com base em uma palavra-chave que seja parte da mensagem.
        *
        * @param string $filter Palavra-chave para filtrar os logs. Padrão é string vazia (sem filtro).
        * @return array Retorna um array associativo com os logs ou um array vazio em caso de erro ou ausência de registros.
        */
        public static function getLogs($filter = '') {
            try {
                // Obtém a conexão com o banco de dados
                $db = Database::getConnection();
                // Define a consulta SQL base para obter os logs
                $sql = "SELECT * FROM logs";
                // Se um filtro for fornecido, adiciona uma cláusula WHERE para filtrar mensagens
                if (!empty($filter)) {
                    // Sanitiza o filtro para evitar possíveis injeções e remover caracteres indesejados
                    $filter = filter_var(trim($filter), FILTER_SANITIZE_STRING);
                    $sql .= " WHERE message LIKE :filter";
                    // Prepara a consulta com o parâmetro de filtro
                    $stmt = $db->prepare($sql);
                    $stmt->execute([':filter' => '%' . $filter . '%']);
                } else {
                    // Se nenhum filtro for fornecido, executa a consulta diretamente
                    $stmt = $db->query($sql);
                }
                // Recupera todos os logs como um array associativo
                $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return is_array($logs) ? $logs : [];
            } catch (Exception $e) {
                // Em caso de erro, você pode optar por logar o erro aqui.
                // Retorna um array vazio caso ocorra alguma exceção.
                return [];
            }
        }
    }