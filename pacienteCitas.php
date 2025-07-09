<?php
  session_start();
  require_once '../conexion/conexion.php';

  if (!isset($_SESSION['PacienteId'])) {
      header('Location: ../presentacion/login.php');
      exit();
  }

  $pacienteId = $_SESSION['PacienteId'];
  $nombre = $_SESSION['NombrePaciente'];
  $apellidos = $_SESSION['ApellidosPaciente'];

  $conn = Conexion::getInstancia()->getConexion();

  // Citas pendientes
  $queryPendientes = "SELECT * FROM citas WHERE PacienteId = :pacienteId AND Estado = 'Agendada' ORDER BY Fecha ASC";
  $stmtPendientes = $conn->prepare($queryPendientes);
  $stmtPendientes->bindParam(':pacienteId', $pacienteId, PDO::PARAM_INT);
  $stmtPendientes->execute();
  $pendientes = $stmtPendientes->fetchAll(PDO::FETCH_ASSOC);

  // Historial
  $queryHistorial = "SELECT * FROM citas WHERE PacienteId = :pacienteId ORDER BY Fecha DESC";
  $stmtHistorial = $conn->prepare($queryHistorial);
  $stmtHistorial->bindParam(':pacienteId', $pacienteId, PDO::PARAM_INT);
  $stmtHistorial->execute();
  $historial = $stmtHistorial->fetchAll(PDO::FETCH_ASSOC);
  ?>
  <!DOCTYPE html>
  <html lang="es">
  <head>
    <meta charset="UTF-8">
    <title>Mis Citas</title>
  <style>
    /* === Tabla base === */
  table {
    width: 100%;
    border-collapse: collapse;
    margin: 1rem 0;
  }

  th, td {
    border: 1px solid #ddd;
    text-align: left;
    padding: 10px;
  }

  th {
    background:rgb(5, 5, 5);
    color: #fff;
  }

  /* === Responsive para TODAS las tablas === */
  @media (max-width: 768px) {
    table, thead, tbody, th, td, tr {
      display: block;
    }

    thead {
      display: none;
    }

    tr {
      margin-bottom: 1rem;
      border-bottom: 2px solid #ddd;
    }

    td {
      position: relative;
      padding-left: 50%;
      text-align: left;
      border: none;
      border-bottom: 1px solid #eee;
    }

    td::before {
      content: attr(data-label);
      position: absolute;
      left: 10px;
      top: 10px;
      font-weight: bold;
      text-transform: uppercase;
      font-size: 12px;
      color: #555;
    }
  }


  </style>
    
  </head>
  <body>

    <div class="section">
    <h2>Citas Pendientes</h2>
    <?php if ($pendientes): ?>
      <div class="table-container">
        <table>
    <thead>
      <tr>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Notas</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($pendientes as $cita): ?>
      <tr>
        <td data-label="Fecha"><?php echo htmlspecialchars($cita['Fecha']); ?></td>
        <td data-label="Hora"><?php echo htmlspecialchars($cita['Hora']); ?></td>
        <td data-label="Notas"><?php echo htmlspecialchars($cita['Notas']); ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

      </div>
    <?php else: ?>
      <p>No tiene citas pendientes.</p>
    <?php endif; ?>
  </div>


    <div class="section">
      <h2>Historial de Citas</h2>
      <?php if ($historial): ?>
        <table>
          <thead>
            <tr>
              <th>Fecha</th>
              <th>Hora</th>
              <th>Estado</th>
              <th>Notas</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($historial as $cita): ?>
              <tr>
                <td data-label="Fecha"><?php echo htmlspecialchars($cita['Fecha']); ?></td>
                <td data-label="Hora"><?php echo htmlspecialchars($cita['Hora']); ?></td>
                <td data-label="Estado"><?php echo htmlspecialchars($cita['Estado']); ?></td>
                <td data-label="Notas"><?php echo htmlspecialchars($cita['Notas']); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p>No tiene historial de citas.</p>
      <?php endif; ?>
    </div>

  </body>
  </html>