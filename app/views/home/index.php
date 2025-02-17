<?php
    // Inicia a sessão, se necessário
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Define o título da página para uso no header
    $title = "Home - Simple CRM";
    // Inclui os arquivos parciais do layout
    require 'app/views/partials/header.php';
    require 'app/views/partials/navbar.php';
?>
<div class="container mt-5">
    <h1>Bem-vindo ao SimpleCRM</h1>
    <!--<p>Esta é a página inicial da aplicação. Aqui podemos apresentar as principais novidades, promoções ou informações relevantes para o usuário.</p>-->
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse at iaculis felis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nullam quis augue sit amet libero finibus varius at aliquam nibh. Curabitur mi nibh, tristique a elit in, varius congue nisl. Cras ligula tortor, bibendum quis varius ut, cursus ut nulla. Sed a urna rutrum, mollis ex eget, varius elit. Aenean finibus purus mauris, eu feugiat nulla dictum egestas. Phasellus eu nisi cursus nulla ultricies sagittis et eu velit. Etiam in commodo lorem. Duis interdum diam sit amet gravida maximus. Nunc sed imperdiet urna, et gravida enim. Mauris mattis diam ac mauris fringilla, eget pretium lorem finibus. Sed sed interdum lectus. Cras sed augue quis velit faucibus ornare eget sed lorem. Nam sit amet nunc rutrum, bibendum dolor quis, pretium libero. Vivamus diam nisl, finibus ac purus posuere, congue congue libero.</p>
</div>
<?php require 'app/views/partials/footer.php'; ?>