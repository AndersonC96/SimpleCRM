<?php
    class Survey {
        /**
        * Processa e salva a resposta da pesquisa.
        *
        * Valida a nota (rating) para que seja numérica e esteja entre 0 e 10,
        * e valida o comentário (comment) para não exceder 500 caracteres (se fornecido).
        *
        * @param mixed  $rating  A nota da pesquisa (espera-se um valor numérico entre 0 e 10).
        * @param string $comment O comentário da pesquisa (opcional, máximo 500 caracteres).
        * @return bool Retorna true se a resposta for salva com sucesso, ou false em caso de erro.
        */
        public static function submitSurvey($rating, $comment) {
            // Validação: rating deve estar definido, não vazio e ser numérico.
            if (!isset($rating) || $rating === '' || !is_numeric($rating)) {
                return false;
            }
            $rating = floatval($rating);
            if ($rating < 0 || $rating > 10) {
                return false;
            }
            // Validação opcional: se o comentário for fornecido, ele deve ter no máximo 500 caracteres.
            if (!empty($comment)) {
                $comment = trim($comment);
                if (strlen($comment) > 500) {
                    return false;
                }
                // Sanitiza o comentário para remover possíveis tags ou caracteres indesejados.
                $comment = filter_var($comment, FILTER_SANITIZE_STRING);
            } else {
                $comment = null; // Se o comentário estiver vazio, define como null.
            }
            try {
                $db = Database::getConnection();
                $stmt = $db->prepare("INSERT INTO surveys (rating, comment, created_at) VALUES (:rating, :comment, NOW())");
                return $stmt->execute([
                    ':rating'  => $rating,
                    ':comment' => $comment
                ]);
            } catch (Exception $e) {
                // Aqui você pode logar o erro se necessário.
                return false;
            }
        }
        /**
        * Retorna os resultados e métricas da pesquisa.
        *
        * Este método calcula o NPS (Net Promoter Score) com base nas respostas,
        * separando as notas em Promotores (9-10), Detratores (0-6) e Neutros (7-8),
        * e retorna um array com essas informações.
        *
        * @return array|false Retorna um array associativo com os resultados, ou false em caso de erro.
        */
        public static function getResults() {
            try {
                $db = Database::getConnection();
                // Consulta para contar promotores, detratores e o total de respostas.
                $stmt = $db->query("SELECT SUM(CASE WHEN rating >= 9 THEN 1 ELSE 0 END) AS promoters, SUM(CASE WHEN rating <= 6 THEN 1 ELSE 0 END) AS detractors, COUNT(*) AS total FROM surveys");
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($data && $data['total'] > 0) {
                    $promoters = (int)$data['promoters'];
                    $detractors = (int)$data['detractors'];
                    $total = (int)$data['total'];
                    // Calcula o NPS: porcentagem de promotores menos porcentagem de detratores.
                    $nps = (($promoters - $detractors) / $total) * 100;
                    return [
                        'nps'         => round($nps, 2),
                        'total'       => $total,
                        'promoters'   => $promoters,
                        'detractors'  => $detractors,
                        'neutrals'    => $total - $promoters - $detractors
                    ];
                }
                return false;
            } catch (Exception $e) {
                // Aqui você pode logar o erro se necessário.
                return false;
            }
        }
    }