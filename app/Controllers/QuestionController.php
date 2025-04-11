<?php
    namespace Tisim\SimpleCrm\Controllers;
    use Tisim\SimpleCrm\Models\Survey;
    use Tisim\SimpleCrm\Models\Question;
    class QuestionController extends BaseController {
        public function create() {
            $survey = Survey::find($_GET['survey_id']);
            if (!$survey) {
                flash('Campanha não encontrada.', 'is-danger');
                $this->redirect('index.php?url=surveys');
            }
            $this->view('questions/create', compact('survey'));
        }
        public function store() {
            $question = new Question;
            $question->survey_id = $_POST['survey_id'];
            $question->text = $_POST['text'];
            $question->save();
            flash('Pergunta adicionada com sucesso!', 'is-success');
            $this->redirect("index.php?url=surveys/show&id=" . $_POST['survey_id']);
        }
    }