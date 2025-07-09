<?php
require_once '../conexion/conexion.php';

$conexion = Conexion::getInstancia()->getConexion();
$search = $_GET['search'] ?? ''; // Capturar el término de búsqueda (DNI del paciente)
$citas = [];
$error = null;

// Eliminar cita si se solicita
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    $id = $_POST['id'];

    try {
        $sql = "DELETE FROM Citas WHERE CitaId = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        $error = "Error al eliminar la cita: " . $e->getMessage();
    }
}

// Cambiar estado de cita si se solicita
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cambiar_estado'])) {
    $id = $_POST['id'];
    $estado = $_POST['estado'];

    try {
        $sql = "UPDATE Citas SET Estado = :estado WHERE CitaId = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        $error = "Error al actualizar el estado: " . $e->getMessage();
    }
}

// Obtener citas filtradas por DNI del paciente
try {
    $query = "SELECT 
                Citas.CitaId, 
                Citas.Fecha, 
                Citas.Hora, 
                Pacientes.Nombre AS PacienteNombre, 
                Pacientes.Ape_Paterno AS PacienteApellido, 
                Doctores.DoctorId, 
                Usuarios.Nombre AS DoctorNombre, 
                Usuarios.Ape_Paterno AS DoctorApellido, 
                Citas.Estado, 
                Citas.Notas 
              FROM 
                Citas
              JOIN 
                Pacientes ON Citas.PacienteId = Pacientes.PacienteId
              JOIN 
                Doctores ON Citas.DoctorId = Doctores.DoctorId
              JOIN 
                Usuarios ON Doctores.UsuarioId = Usuarios.UsuarioId";

    // Agregar filtro por DNI si se proporciona
    if ($search) {
        $query .= " WHERE Pacientes.DNI = :search";
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':search', $search, PDO::PARAM_INT);
    } else {
        $stmt = $conexion->prepare($query);
    }

    $stmt->execute();
    $citas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error al obtener las citas: " . $e->getMessage();
}
?>
