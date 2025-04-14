<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Sistema NPS</title>
  <link href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css" rel="stylesheet">
  <!-- ✅ Bulma Tooltip Extension -->
  <link href="https://cdn.jsdelivr.net/npm/bulma-tooltip@3.0.2/dist/css/bulma-tooltip.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <?php
      // Exibe a navbar somente se o usuário estiver logado
      if (isset($_SESSION['usuario'])) {
        include 'view/partials/navbar.php';
      }
    ?>