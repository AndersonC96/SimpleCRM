<?php
    namespace App\Controllers;
    use App\Models\Survey;
    use Respect\Validation\Validator as v;
    class SurveyController extends BaseController {
        /**
        * Lista todas as pesquisas.
        */
        public function index() {
            $surveys = Survey::all();
            $this->render('surveys/index', ['surveys' => $surveys]);
        }
        /**
        * Exibe o formulário para criação de uma nova pesquisa.
        */
        public function create() {
            $this->render('surveys/create');
        }
        /**
        * Processa a criação de uma nova pesquisa.
        */
        public function store() {
            $data = $_POST;
            if (!isset($data['title']) || empty($data['title'])) {
                $error = "Título é obrigatório.";
                return $this->render('surveys/create', ['error' => $error]);
            }
            $survey = new Survey();
            $survey->title       = $data['title'];
            $survey->description = $data['description'] ?? '';
            $survey->created_at  = date('Y-m-d H:i:s');
            $survey->save();
            // Se houver perguntas, implemente o salvamento via loop
            header('Location: /surveys');
            exit;
        }
    }