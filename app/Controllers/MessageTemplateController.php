<?php
    namespace App\Controllers;
    use App\Models\MessageTemplate;
    use Respect\Validation\Validator as v;
    class MessageTemplateController extends BaseController {
        /**
        * Lista todos os templates de mensagem.
        */
        public function index() {
            $templates = MessageTemplate::all();
            $this->render('message_templates/index', ['templates' => $templates]);
        }
        /**
        * Exibe o formulário para criação de um novo template.
        */
        public function create() {
            $this->render('message_templates/create');
        }
        /**
        * Processa a criação de um novo template.
        */
        public function store() {
            $data = $_POST;
            if (!isset($data['subject']) || empty($data['subject'])) {
                $error = "Assunto é obrigatório.";
                return $this->render('message_templates/create', ['error' => $error]);
            }
            $template = new MessageTemplate();
            $template->subject = $data['subject'];
            $template->body    = $data['body'] ?? '';
            $template->save();
            header('Location: /message_templates');
            exit;
        }
        // Métodos para editar, atualizar e excluir templates podem ser adicionados aqui.
    }