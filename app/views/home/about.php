<?php
    // Inicia a sessão, se ainda não estiver iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // Define o título da página para uso no header
    $title = "Sobre - SimpleCRM";
    // Inclui os arquivos parciais do layout: header e navbar
    require 'app/views/partials/header.php';
    require 'app/views/partials/navbar.php';
?>
<div class="container mt-5">
    <h1>Sobre o SimpleCRM</h1>
    <p>
        Bem-vindo à página "Sobre". Aqui você encontrará informações detalhadas sobre a nossa aplicação,
        nossa missão, visão e valores. Este projeto foi desenvolvido com o intuito de oferecer uma solução
        completa para o gerenciamento de clientes, campanhas e pesquisas de satisfação.
    </p>
    <p>
        Nossa equipe é comprometida com a excelência e inovação, sempre buscando melhorar a experiência do usuário
        e entregar um produto de alta qualidade.
    </p>
</div>
<?php
    // Inclui o footer
    require 'app/views/partials/footer.php';
?>