<?php
    class SurveyController {
        public function showForm()  {
            include 'views/survey_form.php';
        }
        public function submit() {
            $rating = $_POST['rating'] ?? null;
            $comment = $_POST['comment'] ?? '';
            if ($rating === null) {
                header('Location: /?error=invalid');
                exit;
            }
            require_once 'model/SurveyModel.php';
            $model = new SurveyModel();
            $model->saveResponse($rating, $comment);
            header('Location: /?success=1');
            exit;
        }
        }
?>