<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $title = "Pesquisa de Satisfação (NPS) - SimpleCRM";
    require 'app/views/partials/header.php';
    require 'app/views/partials/navbar.php';
?>
<div class="container mt-5">
    <h1>Pesquisa de Satisfação (NPS)</h1>
    <!-- Exibe mensagens de erro, se houver -->
    <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; 
                  unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>
    <!-- Formulário de pesquisa -->
    <form action="index.php?url=survey/submit" method="POST" novalidate>
        <div class="mb-3">
            <label for="rating" class="form-label">Nota (0 a 10)</label>
            <input type="number" name="rating" id="rating" class="form-control" min="0" max="10" step="0.1" placeholder="Digite sua nota" required>
        </div>
        <div class="mb-3">
            <label for="comment" class="form-label">Comentário (opcional, até 500 caracteres)</label>
            <textarea name="comment" id="comment" class="form-control" rows="4" maxlength="500" placeholder="Digite seu comentário (opcional)"></textarea>
        </div>
        <!-- Seção para perguntas dinâmicas -->
        <div id="dynamic-questions" class="mb-3">
            <h3>Perguntas adicionais (opcional)</h3>
            <!-- Cada pergunta será um input text; inicialmente, podemos deixar vazio -->
        </div>
        <button type="button" class="btn btn-secondary mb-3" id="addQuestionBtn">Adicionar Pergunta</button>
        <button type="submit" class="btn btn-primary">Enviar Pesquisa</button>
    </form>
</div>
<!-- Script para adicionar perguntas dinamicamente -->
<script>
document.getElementById('addQuestionBtn').addEventListener('click', function() {
    // Cria um novo elemento de input para pergunta
    const container = document.getElementById('dynamic-questions');
    const questionDiv = document.createElement('div');
    questionDiv.className = 'mb-3';
    const label = document.createElement('label');
    label.className = 'form-label';
    // Use um índice dinâmico ou um contador, se necessário
    label.innerText = 'Pergunta adicional:';
    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'additional_questions[]';  // array de perguntas
    input.className = 'form-control';
    input.placeholder = 'Digite sua pergunta';
    questionDiv.appendChild(label);
    questionDiv.appendChild(input);
    container.appendChild(questionDiv);
});
</script>
<?php require 'app/views/partials/footer.php'; ?>