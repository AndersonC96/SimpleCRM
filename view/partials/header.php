<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Sistema NPS</title>
  <link href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <?php
      // Exibe a navbar somente se o usuário estiver logado
      session_start();
      if (isset($_SESSION['usuario'])) {
        include 'view/partials/navbar.php';
      }
    ?>