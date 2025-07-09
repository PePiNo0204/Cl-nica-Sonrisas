
<?php
session_start();
if (!isset($_SESSION['UsuarioId']) || $_SESSION['TipoUsuario'] !== 'Administrador') {
    $_SESSION['error'] = "No tienes permisos para acceder a esta página.";
    header('Location: login.php');
    exit();
}

require_once '../conexion/conexion.php';

$conexion = Conexion::getInstancia()->getConexion();

// Mensaje de error o notificación (ejemplo: mensaje desde la URL)
if (isset($_GET['error'])) {
    $mensaje = htmlspecialchars($_GET['error']);
} elseif (isset($_GET['success'])) {
    $mensaje = htmlspecialchars($_GET['success']);
} else {
    $mensaje = null;
}

// Obtener todos los usuarios
$query = "SELECT * FROM Usuarios";
$stmt = $conexion->prepare($query);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
