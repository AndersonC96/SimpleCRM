<?php
    class Template {
        /**
        * Salva ou atualiza um template de mensagem para um usuário.
        *
        * Se um template com o mesmo nome para o usuário já existir, este método atualiza-o; caso contrário, insere um novo registro.
        *
        * @param int    $userId          ID do usuário dono do template.
        * @param string $templateName    Nome do template.
        * @param string $templateContent Conteúdo do template.
        * @return bool Retorna true em caso de sucesso ou false em caso de erro ou dados inválidos.
        */
        public static function save($userId, $templateName, $templateContent) {
            // Validação dos parâmetros obrigatórios
            if (empty($userId) || intval($userId) <= 0) {
                return false;
            }
            if (empty($templateName) || empty(trim($templateName))) {
                return false;
            }
            if (empty($templateContent) || empty(trim($templateContent))) {
                return false;
            }
            // Sanitiza os dados
            $templateName = filter_var(trim($templateName), FILTER_SANITIZE_STRING);
            $templateContent = filter_var(trim($templateContent), FILTER_SANITIZE_STRING);
            // Validação opcional de comprimento (ajuste os valores conforme sua necessidade)
            if (strlen($templateName) < 2) {
                return false;
            }
            if (strlen($templateContent) < 5) {
                return false;
            }
            try {
                $db = Database::getConnection();
                // Utiliza INSERT com ON DUPLICATE KEY UPDATE para salvar ou atualizar o template.
                // É necessário que exista uma restrição UNIQUE na combinação de (user_id, name) na tabela.
                $stmt = $db->prepare("INSERT INTO templates (user_id, name, content) VALUES (:user_id, :name, :content) ON DUPLICATE KEY UPDATE name = VALUES(name), content = VALUES(content)");
                return $stmt->execute([
                    ':user_id' => $userId,
                    ':name'    => $templateName,
                    ':content' => $templateContent
                ]);
            } catch (Exception $e) {
                // Opcional: log de erro pode ser adicionado aqui.
                return false;
            }
        }
    }