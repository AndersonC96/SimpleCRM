<?php
    // Inicia a sessão, se necessário
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // Define o título da página
    $title = "Painel do Usuário - SimpleCRM";
    // Inclui os parciais do layout (header, navbar)
    require 'app/views/partials/header.php';
    require 'app/views/partials/navbar.php';
    // Suponha que as variáveis $campaigns, $templates, $partialResults e $notifications 
    // tenham sido definidas pelo controlador (UserController->dashboard())
?>
<div class="container mt-5">
    <h1>Bem-vindo, <?= htmlspecialchars($_SESSION['username']) ?></h1>
    <!-- Área de Notificações -->
    <?php if (isset($_SESSION['notifications']) && !empty($_SESSION['notifications'])): ?>
        <div class="alert alert-info">
            <?php foreach ($_SESSION['notifications'] as $notification): ?>
                <p><?= htmlspecialchars($notification) ?></p>
            <?php endforeach; 
                  unset($_SESSION['notifications']); ?>
        </div>
    <?php endif; ?>
    <!-- Seção de Campanhas -->
    <section class="mb-5">
        <h2>Minhas Campanhas</h2>
        <?php if (isset($campaigns) && is_array($campaigns) && !empty($campaigns)): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Status</th>
                        <th>Data de Criação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($campaigns as $camp): ?>
                        <tr>
                            <td><?= htmlspecialchars($camp['id']) ?></td>
                            <td><?= htmlspecialchars($camp['name']) ?></td>
                            <td><?= htmlspecialchars($camp['status'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($camp['created_at'] ?? '') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhuma campanha encontrada.</p>
        <?php endif; ?>
    </section>
    <!-- Seção de Agendamento com Calendário -->
    <section class="mb-5">
        <h2>Agendamento de Mensagens</h2>
        <!-- Um botão para abrir um modal com o calendário para agendar mensagens -->
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#calendarModal">
            Agendar Mensagem
        </button>
        <!-- Modal com o calendário -->
        <div class="modal fade" id="calendarModal" tabindex="-1" aria-labelledby="calendarModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="calendarModalLabel">Agendar Mensagem</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
              </div>
              <div class="modal-body">
                <!-- Calendário para agendamento usando FullCalendar -->
                <div id="calendar"></div>
                <!-- Formulário simples para agendamento, que pode ser expandido -->
                <form id="scheduleForm" action="index.php?url=user/schedule" method="POST" class="mt-3" novalidate>
                    <div class="mb-3">
                        <label for="schedule_date" class="form-label">Data de Agendamento</label>
                        <input type="date" name="schedule_date" id="schedule_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="schedule_time" class="form-label">Horário de Agendamento</label>
                        <input type="time" name="schedule_time" id="schedule_time" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Mensagem</label>
                        <textarea name="message" id="message" class="form-control" rows="3" placeholder="Digite sua mensagem" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Agendar</button>
                </form>
              </div>
            </div>
          </div>
        </div>
    </section>
    <!-- Seção de Templates -->
    <section class="mb-5">
        <h2>Meus Templates</h2>
        <?php if (isset($templates) && is_array($templates) && !empty($templates)): ?>
            <ul class="list-group">
                <?php foreach ($templates as $tpl): ?>
                    <li class="list-group-item">
                        <strong><?= htmlspecialchars($tpl['name']) ?></strong>
                        <p><?= htmlspecialchars($tpl['content']) ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Nenhum template encontrado.</p>
        <?php endif; ?>
        <a href="index.php?url=user/templates" class="btn btn-primary mt-3">Gerenciar Templates</a>
    </section>
    <!-- Seção de Resultados Parciais -->
    <section class="mb-5">
        <h2>Resultados Parciais</h2>
        <?php if (isset($partialResults) && is_array($partialResults) && !empty($partialResults)): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Campanha</th>
                        <th>NPS</th>
                        <th>Total Respostas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($partialResults as $result): ?>
                        <tr>
                            <td><?= htmlspecialchars($result['campaign_name']) ?></td>
                            <td><?= htmlspecialchars($result['nps']) ?></td>
                            <td><?= htmlspecialchars($result['total_responses']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum resultado disponível.</p>
        <?php endif; ?>
    </section>
</div>
<!-- Inclusão do FullCalendar via CDN -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        selectable: true,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        select: function(info) {
            // Preenche o campo de data com a data selecionada
            document.getElementById('schedule_date').value = info.startStr;
        }
    });
    calendar.render();
});
</script>
<?php require 'app/views/partials/footer.php'; ?>