<?php
    namespace App\Controllers;
    use App\Models\Campaign;
    use Respect\Validation\Validator as v;
    class CampaignController extends BaseController {
        /**
        * Lista todas as campanhas.
        */
        public function index() {
            $campaigns = Campaign::all();
            $this->render('campaigns/index', ['campaigns' => $campaigns]);
        }
        /**
        * Exibe o formulário para criação de uma nova campanha.
        */
        public function create() {
            $this->render('campaigns/create');
        }
        /**
        * Processa a criação de uma nova campanha.
        */
        public function store() {
            $data = $_POST;
            if (!isset($data['name']) || empty($data['name'])) {
                $error = "Nome da campanha é obrigatório.";
                return $this->render('campaigns/create', ['error' => $error]);
            }
            $campaign = new Campaign();
            $campaign->name        = $data['name'];
            $campaign->description = $data['description'] ?? '';
            $campaign->start_date  = $data['start_date'];
            $campaign->end_date    = $data['end_date'];
            $campaign->status      = $data['status'] ?? 'inactive';
            $campaign->save();
            header('Location: /campaigns');
            exit;
        }
        // Métodos para editar, atualizar e excluir campanhas podem ser implementados de forma similar.
    }