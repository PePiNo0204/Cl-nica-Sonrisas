<?php
session_start();
require_once '../conexion/conexion.php';

if (!isset($_SESSION['PacienteId'])) {
    header('Location: ../presentacion/login.php');
    exit();
}

$pacienteId = $_SESSION['PacienteId'];
$nombre = $_SESSION['NombrePaciente'];

$conn = Conexion::getInstancia()->getConexion();

// Obtener la próxima cita agendada
$queryProxima = "SELECT * FROM citas 
                 WHERE PacienteId = :pacienteId 
                 AND Estado = 'Agendada' 
                 AND Fecha >= CURDATE() 
                 ORDER BY Fecha ASC, Hora ASC LIMIT 1";
$stmt = $conn->prepare($queryProxima);
$stmt->bindParam(':pacienteId', $pacienteId, PDO::PARAM_INT);
$stmt->execute();
$proximaCita = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Próxima Cita</title>
  <link rel="stylesheet" href="./css/dashboard.css">
</head>
<body>

<div class="alerta-cita">
  <div class="icono">📅</div>
  <h2>Hola <?php echo htmlspecialchars($nombre); ?> 👋</h2>

  <?php if ($proximaCita): ?>
    <p>Tu próxima cita médica está programada para:</p>
    <div class="detalle">
      <strong>🗓 Fecha:</strong> <?php echo date("d/m/Y", strtotime($proximaCita['Fecha'])); ?><br>
      <strong>⏰ Hora:</strong> <?php echo htmlspecialchars($proximaCita['Hora']); ?><br>
      <strong>🩺 Notas:</strong> <?php echo htmlspecialchars($proximaCita['Notas']); ?>
    </div>
    <div class="mensaje">¡Te recomendamos llegar 10 minutos antes! 🕘</div>
  <?php else: ?>
    <p>No tienes citas agendadas por ahora.</p>
    <div class="mensaje">Agenda tu próxima cita desde el menú principal. 🗓</div>
  <?php endif; ?>
</div>

<!-- Botón WhatsApp Asistente -->
<a href="https://wa.me/51928035363" target="_blank" class="whatsapp-float" title="Hablar con un asistente">
  💬 Contactar Asistente
</a>

</body>
</html>
