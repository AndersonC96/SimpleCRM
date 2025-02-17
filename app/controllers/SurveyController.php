<?php
    class SurveyController {
        /**
         * Exibe o formulário de pesquisa de satisfação (NPS).
        */
        public function form() {
            // Exibe a view do formulário de pesquisa
            require 'app/views/user/survey_form.php';
        }
        /**
         * Processa a submissão do formulário de pesquisa.
        */
        public function submit() {
            // Inicia a sessão, se necessário
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Obtém e sanitiza os dados do formulário
                $rating  = isset($_POST['rating']) ? trim($_POST['rating']) : '';
                $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
                $errors  = [];
                // Validação do campo rating
                if (empty($rating)) {
                    $errors[] = 'A nota da pesquisa é obrigatória.';
                } elseif (!is_numeric($rating)) {
                    $errors[] = 'A nota deve ser um número.';
                } else {
                    $rating = floatval($rating);
                    if ($rating < 0 || $rating > 10) {
                        $errors[] = 'A nota deve estar entre 0 e 10.';
                    }
                }
                // Validação opcional do comentário (por exemplo, limitar a 500 caracteres)
                if (!empty($comment) && strlen($comment) > 500) {
                    $errors[] = 'O comentário não pode exceder 500 caracteres.';
                }
                // Se houver erros, armazena-os na sessão e redireciona de volta ao formulário
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header("Location: index.php?url=survey/form");
                    exit;
                }
                // Inclui o modelo de Survey para salvar a resposta
                require_once 'app/models/Survey.php';
                // O método submitSurvey deve processar e salvar a resposta da pesquisa no banco de dados.
                $result = Survey::submitSurvey($rating, $comment);
                if (!$result) {
                    $_SESSION['errors'] = ['Erro ao salvar a resposta da pesquisa.'];
                    header("Location: index.php?url=survey/form");
                    exit;
                } else {
                    $_SESSION['success_message'] = 'Obrigado por responder a pesquisa.';
                }
            }
            // Redireciona para uma página de agradecimento
            header("Location: index.php?url=survey/thankyou");
            exit;
        }
        /**
         * Exibe os resultados e análises da pesquisa (cálculo do NPS, gráficos, etc.).
        */
        public function results() {
            // Inicia a sessão, se necessário
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            // Inclui o modelo de Survey para obter os resultados
            require_once 'app/models/Survey.php';
            try {
                // Busca os resultados da pesquisa.
                // O método getResults() deve retornar os dados necessários para calcular o NPS
                // e outras métricas, por exemplo, um array associativo com 'nps', 'promoters', 'detractors', etc.
                $surveyResults = Survey::getResults();
            } catch (Exception $e) {
                $_SESSION['errors'][] = "Erro ao obter resultados da pesquisa: " . $e->getMessage();
                $surveyResults = [];
            }
            // As variáveis, como $surveyResults, estarão disponíveis na view
            require 'app/views/survey/results.php';
        }
    }