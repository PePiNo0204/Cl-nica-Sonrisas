<?php
session_start();
require_once '../conexion/conexion.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

if (!isset($_SESSION['PacienteId'])) {
    session_unset();
    session_destroy();
    header('Location: ../presentacion/login.php');
    exit();
}

$nombre = $_SESSION['NombrePaciente'];
$apellidos = $_SESSION['ApellidosPaciente'];
$dni = $_SESSION['DNIPaciente'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Portal Paciente</title>
  <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="./css/home.css" />
  <style>
    /* Corrección clave */
    body {
      margin: 0;
      padding: 0;
      display: flex;
      height: 100vh;
      overflow: hidden;
    }
    .sidebar {
      flex-shrink: 0;
    }
    .main-content {
      flex-grow: 1;
      height: 100vh;
    }
    .main-content iframe {
      width: 100%;
      height: 100%;
      border: none;
    }
  </style>
</head>
<body>

<nav class="sidebar">
  <header>
    <i class='bx bx-menu toggle'></i>
    <div class="logo">
      <i class='bx bx-user'></i>
      <span class="logo-text"><?php echo htmlspecialchars($nombre . ' ' . $apellidos); ?></span>
    </div>
  </header>

  <div class="menu">
    <ul class="menu-links">
      <li class="nav-link">
        <a href="pacienteDashboard.php" target="content-area">
          <i class='bx bx-home'></i>
          <span class="text">Dashboard</span>
        </a>
      </li>
      <li class="nav-link">
        <a href="pacienteCitas.php" target="content-area">
          <i class='bx bx-calendar'></i>
          <span class="text">Ver Citas</span>
        </a>
      </li>
    </ul>
  </div>

  <div class="logout">
    <a href="../presentacion/login.php">
      <i class='bx bx-log-out'></i>
      <span class="text">Salir</span>
    </a>
  </div>
</nav>

<main class="main-content">
  <iframe id="content-area" name="content-area" src="pacienteDashboard.php"></iframe>
</main>

<script>
  const toggle = document.querySelector(".toggle");
  const sidebar = document.querySelector(".sidebar");
  const mainContent = document.querySelector(".main-content");

  toggle.addEventListener("click", () => {
    sidebar.classList.toggle("collapsed");
  });
</script>

</body>
</html>