<?php
require_once '../conexion/conexion.php';

$conexion = Conexion::getInstancia()->getConexion();
$search = $_GET['search'] ?? ''; // Capturar el término de búsqueda (DNI)
$pacientes = [];
$error = null;

// Si se solicita cambiar el estado de un paciente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cambiarEstado'])) {
    $id = $_POST['id'];
    $nuevoEstado = $_POST['nuevoEstado'];

    try {
        $sql = "UPDATE Pacientes SET Estado = :nuevoEstado WHERE PacienteId = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':nuevoEstado', $nuevoEstado, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        $error = "Error al cambiar el estado del paciente: " . $e->getMessage();
    }
}

// Obtener los pacientes según el buscador o lista completa
try {
    if ($search) {
        $query = "SELECT * FROM Pacientes WHERE DNI LIKE :search";
        $stmt = $conexion->prepare($query);
        $searchTerm = "%$search%";
        $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
    } else {
        $query = "SELECT * FROM Pacientes";
        $stmt = $conexion->prepare($query);
    }
    $stmt->execute();
    $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error al obtener los pacientes: " . $e->getMessage();
}
?>
