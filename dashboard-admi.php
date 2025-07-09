<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DASHBOARD</title>
  <link rel="stylesheet" href="./css/dashboard-admi.css">
  <!-- Agregar Font Awesome para iconos -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
  <div class="container" id="dashboard-container">
    <!-- Tarjeta de Usuarios -->
    <article class="card">
      <img
        class="card__background"
        src="./img/usuarios.jpg"  <!-- Imagen para usuarios -->
      <div class="card__content">
        <div class="card__content--container">
          <h2 class="card__title">USUARIOS</h2>
          <p class="card__description">
            Total de usuarios registrados en el sistema.
          </p>
          <div class="number" id="usuarios">0</div>
        </div>
        <button class="card__button">
          <a href="adminUsuarios.php" class="btn-link">
            <i class="fas fa-users"></i> Ver más
          </a>
        </button>
      </div>
    </article>

    <!-- Tarjeta de Doctores -->
    <article class="card">
      <img
        class="card__background"
        src="./img/doctores.jpg"  <!-- Imagen para doctores -->
      <div class="card__content">
        <div class="card__content--container">
          <h2 class="card__title">DOCTORES</h2>
          <p class="card__description">
            Total de doctores disponibles en el sistema.
          </p>
          <div class="number" id="doctores">0</div>
        </div>
        <button class="card__button">
          <a href="adminDoctor.php" class="btn-link">
            <i class="fas fa-user-md"></i> Ver más
          </a>
        </button>
      </div>
    </article>

    <!-- Tarjeta de Asistentes -->
    <article class="card">
      <img
        class="card__background"
        src="./img/asistentes.jpg"  <!-- Imagen para asistentes -->
      <div class="card__content">
        <div class="card__content--container">
          <h2 class="card__title">ASISTENTES</h2>
          <p class="card__description">
            Total de asistentes al servicio de atención.
          </p>
          <div class="number" id="asistentes">0</div>
        </div>
        <button class="card__button">
          <a href="adminUsuarios.php" class="btn-link">
            <i class="fas fa-user-tie"></i> Ver más
          </a>
        </button>
      </div>
    </article>

    <!-- Tarjeta de Administradores -->
    <article class="card">
      <img
        class="card__background"
        src="./img/administradores.jpg"  <!-- Imagen para administradores -->
      <div class="card__content">
        <div class="card__content--container">
          <h2 class="card__title">ADMINISTRADORES</h2>
          <p class="card__description">
            Total de administradores en el sistema.
          </p>
          <div class="number" id="administradores">0</div>
        </div>
        <button class="card__button">
          <a href="adminUsuarios.php" class="btn-link">
            <i class="fas fa-cogs"></i> Ver más
          </a>
        </button>
      </div>
    </article>

    <!-- Tarjeta de Pacientes -->
    <article class="card">
      <img
        class="card__background"
        src="./img/pacientes.jpg"  <!-- Imagen para pacientes -->
      <div class="card__content">
        <div class="card__content--container">
          <h2 class="card__title">PACIENTES</h2>
          <p class="card__description">
            Total de pacientes registrados en el sistema.
          </p>
          <div class="number" id="pacientes">0</div>
        </div>
        <button class="card__button">
          <a href="adminPacientes.php" class="btn-link">
            <i class="fas fa-bed"></i> Ver más
          </a>
        </button>
      </div>
    </article>

    <!-- Tarjeta de Citas -->
    <article class="card">
      <img
        class="card__background"
        src="./img/citas.jpg"  <!-- Imagen para citas -->
      <div class="card__content">
        <div class="card__content--container">
          <h2 class="card__title">CITAS</h2>
          <p class="card__description">
            Total de citas registradas en el sistema.
          </p>
          <div class="number" id="citas">0</div>
        </div>
        <button class="card__button">
          <a href="admincitas.php" class="btn-link">
            <i class="fas fa-calendar-check"></i> Ver más
          </a>
        </button>
      </div>
    </article>
  </div>

  <script src="js/dashboard-admi.js"></script>
</body>
</html>
