<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'SimpleCRM' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.0/css/bulma.min.css">
</head>
<body>
    <section class="section">
        <div class="container">
            <h1 class="title"><?= $title ?? 'SimpleCRM' ?></h1>
            <hr>
            <?php require $content ?>
        </div>
    </section>
</body>
</html>