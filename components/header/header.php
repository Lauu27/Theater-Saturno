<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<link rel="stylesheet" href="/PP/components/header/header.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<header class="header">

  <div class="logo-container">
    <a href="/PP/index.php">
      <img src="/PP/components/img/gglogo.png" class="logo">
    </a>
  </div>

  <nav>
    <ul>
      <li><a href="/PP/index.php">Inicio</a></li>
      <li><a href="/PP/pages/cartelera.php">Cartelera</a></li>
      <li><a href="/PP/pages/contacto.php">Contacto</a></li>
    </ul>
  </nav>

  <div class="header-actions">

    <div class="settings-btn <?= isset($_SESSION['usuario_id']) ? 'logged' : 'guest' ?>" id="settingsBtn">
      <?php if (isset($_SESSION['usuario_id'])): ?>
        <img
          src="/PP/uploads/perfiles/<?= $_SESSION['foto'] ?? 'default.png' ?>?v=<?= time() ?>"
          class="user-img"
          alt="Usuario">
      <?php else: ?>
        <i class="fa-solid fa-user"></i>
      <?php endif; ?>
    </div>

    <div class="settings-menu" id="settingsMenu">
      <?php if (isset($_SESSION['usuario_id'])): ?>
        <a href="/PP/pages/perfil.php">Perfil</a>
        <a href="/PP/pages/logout.php">Cerrar sesión</a>
      <?php else: ?>
        <a href="/PP/pages/login.php">Iniciar sesión</a>
        <a href="/PP/pages/register.php">Registrarse</a>
      <?php endif; ?>
    </div>

  </div>

</header>

<script src="/PP/components/header/header.js"></script>
