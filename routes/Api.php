<?php
    use Tisim\SimpleCrm\Models\Survey;
    // Simula uma “API router” simples por URL
    $uri = rtrim($_GET['url'] ?? '/', '/');
    // Exemplo: GET /api/surveys
    if ($uri === 'api/surveys') {
        header('Content-Type: application/json');
        echo json_encode(Survey::all());
        exit;
    }
    // Exemplo: GET /api/survey?id=1
    if ($uri === 'api/survey' && isset($_GET['id'])) {
        $survey = Survey::find($_GET['id']);
        header('Content-Type: application/json');
        echo json_encode($survey);
        exit;
    }
    http_response_code(404);
    echo json_encode(['error' => 'Rota não encontrada']);