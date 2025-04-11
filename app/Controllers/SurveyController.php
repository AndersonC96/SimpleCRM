<?php
	namespace Tisim\SimpleCrm\Controllers;
	use Tisim\SimpleCrm\Models\Survey;
	class SurveyController extends BaseController {
		public function index() {
			$surveys = Survey::all();
			$this->view('surveys/index', compact('surveys'));
		}
		public function create() {
			$this->view('surveys/create');
		}
		public function store() {
			$survey = new Survey;
			$survey->title = $_POST['title'];
			$survey->description = $_POST['description'];
			$survey->save();
			$this->redirect('surveys');
		}
		public function show($id) {
			$survey = Survey::find($id);
			$this->view('surveys/show', compact('survey'));
		}
		public function delete($id) {
			$survey = Survey::find($id);
			$survey?->delete();
			$this->redirect('surveys');
    	}
		public function store() {
    		$survey = new Survey;
    		$survey->title = $_POST['title'];
    		$survey->description = $_POST['description'];
    		$survey->save();
		    // Gera popup com redirecionamento usando JS
    		echo "<script>
        		alert('Pesquisa criada com sucesso!');
        		window.location.href = 'index.php?url=surveys';
    		</script>";
		}
	}