<?php
    class FormController {
        /**
        * Construtor: Verifica se o usuário está autenticado.
        * Caso não esteja, redireciona para a página de login.
        */
        public function __construct() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            if (!isset($_SESSION['user_id'])) {
                header("Location: index.php?url=auth/login");
                exit;
            }
        }
        /**
        * Exibe a lista de formulários do usuário.
        */
        public function index() {
            require_once 'app/models/Form.php';
            try {
                // Busca todos os formulários do usuário autenticado.
                $forms = Form::getAllByUser($_SESSION['user_id']);
            } catch (Exception $e) {
                $_SESSION['errors'][] = "Erro ao buscar formulários: " . $e->getMessage();
                $forms = [];
            }
            require 'app/views/form/index.php';
        }
        /**
        * Exibe o formulário para criação de um novo formulário e processa sua criação.
        */
        public function create() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $errors = [];
                // Obtém e sanitiza os dados do formulário
                $formName = isset($_POST['form_name']) ? trim($_POST['form_name']) : '';
                $formContent = isset($_POST['form_content']) ? trim($_POST['form_content']) : '';
                // Valida os campos obrigatórios
                if (empty($formName)) {
                    $errors[] = "O nome do formulário é obrigatório.";
                }
                if (empty($formContent)) {
                    $errors[] = "O conteúdo do formulário é obrigatório.";
                }
                // Se houver erros, armazena-os na sessão e redireciona para o formulário de criação
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header("Location: index.php?url=form/create");
                    exit;
                }
                // Processa a criação do formulário
                require_once 'app/models/Form.php';
                $result = Form::create($_SESSION['user_id'], $formName, $formContent);
                if (!$result) {
                    $_SESSION['errors'][] = "Erro ao criar formulário.";
                } else {
                    $_SESSION['success_message'] = "Formulário criado com sucesso.";
                }
                header("Location: index.php?url=form/index");
                exit;
            }
            // Exibe a view para criação de formulário
            require 'app/views/form/create.php';
        }
        /**
        * Exibe o formulário para edição de um formulário existente e processa a atualização.
        *
        * @param int $id ID do formulário a ser editado.
        */
        public function edit($id) {
            require_once 'app/models/Form.php';
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $errors = [];
                $formName = isset($_POST['form_name']) ? trim($_POST['form_name']) : '';
                $formContent = isset($_POST['form_content']) ? trim($_POST['form_content']) : '';
                // Valida os campos obrigatórios
                if (empty($formName)) {
                    $errors[] = "O nome do formulário é obrigatório.";
                }
                if (empty($formContent)) {
                    $errors[] = "O conteúdo do formulário é obrigatório.";
                }
                // Se houver erros, armazena-os na sessão e redireciona para o formulário de edição
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header("Location: index.php?url=form/edit/" . intval($id));
                    exit;
                }
                // Atualiza o formulário
                $result = Form::update($id, $_SESSION['user_id'], $formName, $formContent);
                if (!$result) {
                    $_SESSION['errors'][] = "Erro ao atualizar o formulário.";
                } else {
                    $_SESSION['success_message'] = "Formulário atualizado com sucesso.";
                }
                header("Location: index.php?url=form/index");
                exit;
            } else {
                // Para requisições GET, busca os dados do formulário para preencher o formulário de edição
                $form = Form::find($id, $_SESSION['user_id']);
                if (!$form) {
                    $_SESSION['errors'][] = "Formulário não encontrado.";
                    header("Location: index.php?url=form/index");
                    exit;
                }
            }
            require 'app/views/form/edit.php';
        }
        /**
        * Processa a exclusão de um formulário.
        *
        * @param int $id ID do formulário a ser excluído.
        */
        public function delete($id) {
            require_once 'app/models/Form.php';
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $result = Form::delete($id, $_SESSION['user_id']);
                if (!$result) {
                    $_SESSION['errors'][] = "Erro ao excluir o formulário.";
                } else {
                    $_SESSION['success_message'] = "Formulário excluído com sucesso.";
                }
                header("Location: index.php?url=form/index");
                exit;
            } else {
                // Se não for POST, opcionalmente exiba uma view de confirmação de exclusão
                $form = Form::find($id, $_SESSION['user_id']);
                if (!$form) {
                    $_SESSION['errors'][] = "Formulário não encontrado.";
                    header("Location: index.php?url=form/index");
                    exit;
                }
                require 'app/views/form/delete.php';
            }
        }
    }