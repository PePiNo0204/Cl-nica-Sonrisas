<?php
session_start();
require_once '../conexion/conexion.php';

// Verificar autenticación
if (!isset($_SESSION['DoctorId'])) {
    header('Location: login.php');
    exit();
}

$doctorId = $_SESSION['DoctorId'];
$searchDni = isset($_GET['dni']) ? trim($_GET['dni']) : '';

try {
    $conexion = Conexion::getInstancia()->getConexion();

    // Citas hasta HOY inclusive
    $sql = "SELECT 
                c.CitaId,
                c.Fecha,
                c.Hora,
                c.Estado,
                c.Notas,
                p.Nombre AS PacienteNombre,
                p.Ape_Paterno AS PacienteApellidoPaterno,
                p.Ape_Materno AS PacienteApellidoMaterno,
                p.DNI AS PacienteDNI
            FROM Citas c
            INNER JOIN Pacientes p ON c.PacienteId = p.PacienteId
            WHERE c.DoctorId = :doctorId AND c.Fecha <= CURDATE()";

    if ($searchDni !== '') {
        $sql .= " AND p.DNI LIKE :dni";
    }

    $sql .= " ORDER BY c.Fecha DESC, c.Hora DESC";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':doctorId', $doctorId, PDO::PARAM_INT);

    if ($searchDni !== '') {
        $dniParam = "%$searchDni%";
        $stmt->bindParam(':dni', $dniParam, PDO::PARAM_STR);
    }

    $stmt->execute();
    $citas = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $error = "Error al obtener las citas: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas Anteriores</title>
    <link rel="stylesheet" href="./css/CitasAnteriores.css">
    <script src="./js/CitasAnteriores.js" defer></script>
</head>
<body>
    <header class="menu">
        <!-- Buscador por DNI -->
        <form id="dniSearchForm" method="GET" action="">
            <input type="text" name="dni" id="dniSearch" placeholder="Buscar por DNI" value="<?php echo htmlspecialchars($searchDni); ?>" />
            <button type="submit">Buscar</button>
        </form>
    </header>

    <div class="container">
        <h1>Citas Anteriores</h1>

        <?php if (isset($error)): ?>
            <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
        <?php elseif (empty($citas)): ?>
            <p class="no-results">No se encontraron citas anteriores.</p>
        <?php else: ?>
            <div class="citas-grid">
                <?php foreach ($citas as $cita): ?>
                    <div class="cita-card" data-id="<?php echo $cita['CitaId']; ?>" data-estado="<?php echo $cita['Estado']; ?>">
                        <h3><?php echo htmlspecialchars($cita['PacienteNombre'] . ' ' . $cita['PacienteApellidoPaterno'] . ' ' . $cita['PacienteApellidoMaterno']); ?></h3>
                        <p><strong>Fecha:</strong> <?php echo htmlspecialchars($cita['Fecha']); ?></p>
                        <p><strong>Hora:</strong> <?php echo htmlspecialchars($cita['Hora']); ?></p>
                        <p><strong>Estado:</strong> <span class="estado-cita"><?php echo htmlspecialchars($cita['Estado']); ?></span></p>
                        <p><strong>Notas:</strong> <?php echo htmlspecialchars($cita['Notas']); ?></p>
                        <p><strong>DNI:</strong> <?php echo htmlspecialchars($cita['PacienteDNI']); ?></p>

                        <a class="boton-estado" href="cambiarEstadoCita.php?citaId=<?php echo $cita['CitaId']; ?>">Cambiar Estado</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
