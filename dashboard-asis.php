<?php
// Si necesitas proteger el acceso, puedes usar sesiones aquí:
session_start();
// if (!isset($_SESSION['usuario'])) {
//     header("Location: login.php");
//     exit();
// }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Asistente Médico</title>
  <link rel="stylesheet" href="./css/dashboard-asist.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <h1>Dashboard Asistente Médico</h1>

  <div class="container">
    <section class="articles">
      <!-- Tarjeta 1 -->
      <article class="card">
        <div class="article-wrapper">
          <i class="fas fa-calendar-check fa-3x"></i>
          <div class="article-body">
            <h2>Ver Citas Agregadas</h2>
            <p>Accede a las citas que ya has programado y gestionadas para mantener todo organizado.</p>
            <a href="admincitas.php" target="content-area" class="read-more">Ver Citas</a>
          </div>
        </div>
      </article>

      <!-- Tarjeta 2 -->
      <article class="card">
        <div class="article-wrapper">
          <i class="fas fa-user-injured fa-3x"></i>
          <div class="article-body">
            <h2>Pacientes Registrados</h2>
            <p>Consulta la lista de pacientes registrados para un seguimiento adecuado.</p>
            <a href="adminPacientes.php" target="content-area" class="read-more">Ver Pacientes</a>
          </div>
        </div>
      </article>

      <!-- Tarjeta 3 -->
      <article class="card">
        <div class="article-wrapper">
          <i class="fas fa-user-plus fa-3x"></i>
          <div class="article-body">
            <h2>Agregar Paciente</h2>
            <p>Introduce nuevos pacientes para gestionar su atención médica.</p>
            <a href="agregarPaciente.php" target="content-area" class="read-more">Agregar Paciente</a>
          </div>
        </div>
      </article>

      <!-- Tarjeta 4 -->
      <article class="card">
        <div class="article-wrapper">
          <i class="fas fa-calendar-plus fa-3x"></i>
          <div class="article-body">
            <h2>Agregar Cita</h2>
            <p>Programa nuevas citas para pacientes y organiza tu calendario.</p>
            <a href="citas.php" target="content-area" class="read-more">Agregar Cita</a>
          </div>
        </div>
      </article>
    </section>

    <!-- Estadísticas (gráfico) -->
    <section id="stats">
      <h2 style="text-align: center; margin-bottom: 1rem;">Estadísticas Rápidas</h2>
      <canvas id="chartBar"></canvas>
    </section>
  </div>

  <script>
    const ctx = document.getElementById('chartBar').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Pacientes', 'Citas', 'Canceladas', 'Reprogramadas'],
        datasets: [{
          label: 'Total',
          data: [120, 90, 10, 15], // Puedes reemplazar estos valores con PHP si deseas
          backgroundColor: 'white',
          borderColor: 'black',
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              color: 'white'
            }
          },
          x: {
            ticks: {
              color: 'white'
            }
          }
        },
        plugins: {
          legend: {
            labels: {
              color: 'white'
            }
          }
        }
      }
    });
  </script>
</body>
</html>
