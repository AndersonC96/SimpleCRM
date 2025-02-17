// Aguarda o carregamento completo do DOM
document.addEventListener("DOMContentLoaded", function() {
    console.log("main.js carregado com sucesso!");
    // Exemplo: Alternar menu responsivo (caso não utilize o Bootstrap JS ou queira um comportamento customizado)
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    if (navbarToggler && navbarCollapse) {
        navbarToggler.addEventListener('click', function() {
            // Alterna a classe 'show' para exibir ou ocultar o menu
            navbarCollapse.classList.toggle('show');
        });
    }
    // Exemplo: Validação personalizada de formulários com o atributo "novalidate"
    // Caso queira fazer validação customizada em vez da validação padrão do navegador
    const forms = document.querySelectorAll('form[novalidate]');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            // Exemplo simples: verifica se o formulário está válido
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
                alert("Por favor, preencha corretamente os campos do formulário.");
            }
            form.classList.add('was-validated');
        });
    });
    // Exemplo: Outras funcionalidades podem ser adicionadas aqui,
    // como requisições AJAX, manipulação de modais, etc.
});