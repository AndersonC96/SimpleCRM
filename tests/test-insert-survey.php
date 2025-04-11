<?php
    require __DIR__ . '/../vendor/autoload.php';
    require __DIR__ . '/../config/database.php';
    use Tisim\SimpleCrm\Models\Survey;
    $survey = new Survey;
    $survey->title = 'Pesquisa de Satisfação';
    $survey->description = 'Queremos saber sua opinião!';
    $survey->save();
    echo "✅ Pesquisa criada com ID: " . $survey->id;
?>