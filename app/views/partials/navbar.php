<?php
// app/views/partials/navbar.php

// Inicia a sessão, se ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <!-- Logo/Marca -->
    <a class="navbar-brand" href="index.php">SimpleCRM</a>
    <!-- Botão para telas menores -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" 
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Conteúdo da Navbar -->
    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- Links públicos -->
        <li class="nav-item">
          <a class="nav-link" href="index.php?url=home/index">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?url=home/about">Sobre</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?url=home/contact">Contato</a>
        </li>
        
        <?php if (isset($_SESSION['user_id'])): ?>
          <!-- Painel do Usuário -->
          <li class="nav-item">
            <a class="nav-link" href="index.php?url=user/dashboard">Painel do Usuário</a>
          </li>

          <!-- Menu de Formulários -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="formDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Formulários
            </a>
            <ul class="dropdown-menu" aria-labelledby="formDropdown">
              <li><a class="dropdown-item" href="index.php?url=form/create">Criar Formulário</a></li>
              <li><a class="dropdown-item" href="index.php?url=form/edit">Editar Formulário</a></li>
              <li><a class="dropdown-item" href="index.php?url=form/delete">Remover Formulário</a></li>
            </ul>
          </li>

          <!-- Agendamento de Mensagens -->
          <li class="nav-item">
            <a class="nav-link" href="index.php?url=user/schedule">Agendar Mensagens</a>
          </li>
          
          <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <!-- Menu Administrativo -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Administração
              </a>
              <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                <li><a class="dropdown-item" href="index.php?url=admin/dashboard">Dashboard</a></li>
                <li><a class="dropdown-item" href="index.php?url=admin/manage_users">Gerenciar Usuários</a></li>
                <li><a class="dropdown-item" href="index.php?url=admin/manage_clients">Gerenciar Clientes</a></li>
                <li><a class="dropdown-item" href="index.php?url=admin/manage_campaigns">Gerenciar Campanhas</a></li>
                <li><a class="dropdown-item" href="index.php?url=admin/logs">Logs e Histórico</a></li>
              </ul>
            </li>
          <?php endif; ?>
        <?php endif; ?>
      </ul>
      <!-- Itens à direita: Login/Logout -->
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <?php if (isset($_SESSION['user_id'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="index.php?url=auth/logout">Sair</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="index.php?url=auth/login">Entrar</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?url=auth/register">Registrar</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
