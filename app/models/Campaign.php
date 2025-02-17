<?php
    // Carrega a classe Database para estabelecer a conexão com o banco de dados
    require_once __DIR__ . '/../helpers/Database.php';
    class Campaign {
        /**
        * Retorna todas as campanhas/pesquisas.
        *
        * @return array Array de campanhas ou um array vazio em caso de erro.
        */
        public static function getAll() {
            try {
                $db = Database::getConnection();
                $stmt = $db->query("SELECT * FROM campaigns");
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                // Opcional: log do erro
                return [];
            }
        }
        /**
        * Cria uma nova campanha.
        *
        * @param string $campaignName Nome da campanha.
        * @param string $startDate    Data de início no formato YYYY-MM-DD.
        * @param string $endDate      Data de término no formato YYYY-MM-DD.
        * @return bool Retorna true se a campanha for criada com sucesso, ou false em caso de erro.
        */
        public static function create($campaignName, $startDate, $endDate) {
            // Valida os parâmetros obrigatórios
            if (empty($campaignName) || empty($startDate) || empty($endDate)) {
                return false;
            }
            // Sanitiza os dados
            $campaignName = filter_var(trim($campaignName), FILTER_SANITIZE_STRING);
            $startDate    = filter_var(trim($startDate), FILTER_SANITIZE_STRING);
            $endDate      = filter_var(trim($endDate), FILTER_SANITIZE_STRING);
            // Verifica se, após sanitização, os campos continuam válidos
            if (empty($campaignName) || empty($startDate) || empty($endDate)) {
                return false;
            }
            // Valida o formato das datas (YYYY-MM-DD)
            $d1 = DateTime::createFromFormat('Y-m-d', $startDate);
            if (!($d1 && $d1->format('Y-m-d') === $startDate)) {
                return false;
            }
            $d2 = DateTime::createFromFormat('Y-m-d', $endDate);
            if (!($d2 && $d2->format('Y-m-d') === $endDate)) {
                return false;
            }
            // Verifica se a data de início é anterior ou igual à data de término
            if ($d1 > $d2) {
                return false;
            }
            try {
                $db = Database::getConnection();
                $stmt = $db->prepare("INSERT INTO campaigns (name, start_date, end_date) VALUES (:name, :start_date, :end_date)");
                return $stmt->execute([
                    ':name'       => $campaignName,
                    ':start_date' => $startDate,
                    ':end_date'   => $endDate
                ]);
            } catch (Exception $e) {
                // Opcional: log do erro
                return false;
            }
        }
        /**
        * Atualiza uma campanha existente.
        *
        * @param int    $campaignId   ID da campanha.
        * @param string $campaignName Nome da campanha.
        * @param string $startDate    Data de início no formato YYYY-MM-DD.
        * @param string $endDate      Data de término no formato YYYY-MM-DD.
        * @return bool Retorna true se a campanha for atualizada com sucesso, false caso contrário.
        */
        public static function update($campaignId, $campaignName, $startDate, $endDate) {
            // Validação dos parâmetros obrigatórios
            if (empty($campaignId) || intval($campaignId) <= 0 || empty($campaignName) || empty($startDate) || empty($endDate)) {
                return false;
            }
            // Sanitiza os dados
            $campaignName = filter_var(trim($campaignName), FILTER_SANITIZE_STRING);
            $startDate    = filter_var(trim($startDate), FILTER_SANITIZE_STRING);
            $endDate      = filter_var(trim($endDate), FILTER_SANITIZE_STRING);
            if (empty($campaignName) || empty($startDate) || empty($endDate)) {
                return false;
            }
            // Valida o formato das datas (YYYY-MM-DD)
            $d1 = DateTime::createFromFormat('Y-m-d', $startDate);
            if (!($d1 && $d1->format('Y-m-d') === $startDate)) {
                return false;
            }
            $d2 = DateTime::createFromFormat('Y-m-d', $endDate);
            if (!($d2 && $d2->format('Y-m-d') === $endDate)) {
                return false;
            }
            // Verifica se a data de início é anterior ou igual à data de término
            if ($d1 > $d2) {
                return false;
            }
            try {
                $db = Database::getConnection();
                $stmt = $db->prepare("UPDATE campaigns SET name = :name, start_date = :start_date, end_date = :end_date WHERE id = :id");
                return $stmt->execute([
                    ':name'       => $campaignName,
                    ':start_date' => $startDate,
                    ':end_date'   => $endDate,
                    ':id'         => $campaignId
                ]);
            } catch (Exception $e) {
                // Opcional: log do erro
                return false;
            }
        }
        /**
        * Exclui uma campanha.
        *
        * @param int $campaignId ID da campanha a ser excluída.
        * @return bool Retorna true se a campanha for excluída com sucesso, false em caso de erro.
        */
        public static function delete($campaignId) {
            if (empty($campaignId) || intval($campaignId) <= 0) {
                return false;
            }
            try {
                $db = Database::getConnection();
                $stmt = $db->prepare("DELETE FROM campaigns WHERE id = :id");
                return $stmt->execute([':id' => $campaignId]);
            } catch (Exception $e) {
                // Opcional: log do erro
                return false;
            }
        }
        /**
        * Encontra uma campanha pelo ID.
        *
        * @param int $campaignId ID da campanha a ser buscada.
        * @return array|false Retorna um array associativo com os dados da campanha se encontrada, ou false caso contrário.
        */
        public static function find($campaignId) {
            if (empty($campaignId) || intval($campaignId) <= 0) {
                return false;
            }
            try {
                $db = Database::getConnection();
                $stmt = $db->prepare("SELECT * FROM campaigns WHERE id = :id LIMIT 1");
                $stmt->execute([':id' => $campaignId]);
                $campaign = $stmt->fetch(PDO::FETCH_ASSOC);
                return $campaign ? $campaign : false;
            } catch (Exception $e) {
                // Opcional: log do erro
                return false;
            }
        }
    }