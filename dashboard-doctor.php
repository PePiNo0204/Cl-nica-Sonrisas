<?php
session_start();
if (!isset($_SESSION['DoctorId'])) {
    header("Location: login.php");
    exit();
}

require_once '../conexion/conexion.php';
$conexion = Conexion::getInstancia()->getConexion();

$doctorId = $_SESSION['DoctorId'];
$inicioSemana = date('Y-m-d', strtotime('monday this week'));
$finSemana = date('Y-m-d', strtotime('sunday this week'));

try {
    // Citas pendientes (Agendada)
    $sqlPendientes = "SELECT COUNT(*) FROM Citas 
                      WHERE DoctorId = :doctorId AND Estado = 'Agendada' 
                      AND Fecha BETWEEN :inicio AND :fin";
    $stmtPendientes = $conexion->prepare($sqlPendientes);
    $stmtPendientes->bindParam(':doctorId', $doctorId);
    $stmtPendientes->bindParam(':inicio', $inicioSemana);
    $stmtPendientes->bindParam(':fin', $finSemana);
    $stmtPendientes->execute();
    $citasPendientes = $stmtPendientes->fetchColumn();

    // Citas completadas
    $sqlCompletadas = "SELECT COUNT(*) FROM Citas 
                       WHERE DoctorId = :doctorId AND Estado = 'Completada' 
                       AND Fecha BETWEEN :inicio AND :fin";
    $stmtCompletadas = $conexion->prepare($sqlCompletadas);
    $stmtCompletadas->bindParam(':doctorId', $doctorId);
    $stmtCompletadas->bindParam(':inicio', $inicioSemana);
    $stmtCompletadas->bindParam(':fin', $finSemana);
    $stmtCompletadas->execute();
    $citasCompletadas = $stmtCompletadas->fetchColumn();
} catch (PDOException $e) {
    $citasPendientes = 0;
    $citasCompletadas = 0;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard del Doctor</title>
  <link rel="stylesheet" href="./css/dashboard-doctor.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <header class="header">
    <h1>Bienvenido al Panel del Doctor</h1>
    <p>Administra tus actividades diarias de forma eficiente</p>
  </header>

  <main class="dashboard">
    <section class="cards">
      <article class="card">
        <h2>Mis Citas</h2>
        <p>Accede a todas tus citas agendadas.</p>
        <a href="misCitas.php">Ver Citas</a>
      </article>

      <article class="card">
        <h2>Citas Anteriores</h2>
        <p>Consulta tu historial de citas.</p>
        <a href="CitasAnteriores.php">Historial</a>
      </article>

      <article class="card">
        <h2>Mi Horario</h2>
        <p>Consulta y ajusta tus horarios.</p>
        <a href="misHorarios.php">Ver Horarios</a>
      </article>

      <article class="card">
        <h2>Calendario</h2>
        <p>Consulta tu calendario diario y semanal.</p>
        <a href="calendario.php">Ir al Calendario</a>
      </article>

      <article class="card highlight">
        <h2>Pacientes Atendidos</h2>
        <canvas id="chartPacientes"></canvas>
      </article>

      <article class="card">
        <h2>Citas Pendientes de la Semana</h2>
        <p><?php echo $citasPendientes; ?> cita(s) pendientes entre <?php echo $inicioSemana; ?> y <?php echo $finSemana; ?>.</p>
        <a href="misCitas.php">Ver Pendientes</a>
      </article>

      <article class="card">
        <h2>Citas Completadas de la Semana</h2>
        <p><?php echo $citasCompletadas; ?> cita(s) completadas entre <?php echo $inicioSemana; ?> y <?php echo $finSemana; ?>.</p>
        <a href="CitasAnteriores.php">Ver Completadas</a>
      </article>
    </section>
  </main>

  <script>
    const ctx = document.getElementById('chartPacientes').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie'],
        datasets: [{
          label: 'Pacientes por día',
          data: [5, 8, 6, 7, 9], // Reemplaza por datos reales si lo deseas
          backgroundColor: '#000000'
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false }
        }
      }
    });
  </script>
</body>
</html>
