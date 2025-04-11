<?php
    namespace Tisim\SimpleCrm\Controllers;
    use Tisim\SimpleCrm\Models\Survey;
    use Tisim\SimpleCrm\Models\Invite;
    use Tisim\SimpleCrm\Models\Response;
    use Tisim\SimpleCrm\Services\NpsCalculatorService;
    class DashboardController extends BaseController {
        public function index() {
            $totalSurveys = Survey::count();
            $totalInvites = Invite::count();
            $totalResponses = Response::count();
            // NPS por pesquisa (simples)
            $npsData = [];
            foreach (Survey::all() as $survey) {
                $ratings = Response::whereHas('invite', fn($q) => $q->where('survey_id', $survey->id))
                   ->pluck('rating')
                    ->toArray();
                $score = NpsCalculatorService::calculate($ratings);
                $npsData[] = ['title' => $survey->title, 'score' => $score];
            }
            $this->view('dashboard/index', compact(
                'totalSurveys', 'totalInvites', 'totalResponses', 'npsData'
            ));
        }
    }