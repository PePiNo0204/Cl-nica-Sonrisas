<?php
require_once '../conexion/conexion.php';
require_once 'LoginController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = trim($_POST['codigo'] ?? '');
    $contraseña = trim($_POST['contraseña'] ?? '');
    $dni = trim($_POST['dni'] ?? '');

    // Si se envió el campo DNI → login de paciente
    if (!empty($dni)) {
        try {
            $conn = Conexion::getInstancia()->getConexion();

            $queryPaciente = "SELECT * FROM pacientes WHERE DNI = :dni";
            $stmt = $conn->prepare($queryPaciente);
            $stmt->bindParam(':dni', $dni, PDO::PARAM_INT);
            $stmt->execute();
            $paciente = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($paciente) {
                if ($paciente['Estado'] === 'Inactivo') {
                    $_SESSION['error'] = 'Tu cuenta de paciente está inactiva.';
                    header('Location: ../presentacion/login.php');
                    exit();
                } else {
                    // Guardar datos en sesión
                    $_SESSION['PacienteId'] = $paciente['PacienteId'];
                    $_SESSION['NombrePaciente'] = $paciente['Nombre'];
                    $_SESSION['ApellidosPaciente'] = $paciente['Ape_Paterno'] . ' ' . $paciente['Ape_Materno'];
                    $_SESSION['DNIPaciente'] = $paciente['DNI'];

                    // Redirigir a panel del paciente
                    header('Location: ../presentacion/home-paciente.php');
                    exit();
                }
            } else {
                $_SESSION['error'] = 'DNI inválido o no registrado.';
                header('Location: ../presentacion/login.php');
                exit();
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Error en la conexión: ' . $e->getMessage();
            header('Location: ../presentacion/login.php');
            exit();
        }

    } else {
        // Caso normal: usuarios con código + contraseña
        $loginController = new LoginController();
        $usuario = $loginController->iniciarSesion($codigo, $contraseña);

        if ($usuario) {
            if ($usuario['Estado'] === 'Inactivo') {
                $_SESSION['error'] = 'Tu cuenta está inactiva. Contacta al administrador.';
                header('Location: ../presentacion/login.php');
                exit();
            } else {
                $_SESSION['UsuarioId'] = $usuario['UsuarioId'];
                $_SESSION['TipoUsuario'] = $usuario['TipoUsuario'];
                $_SESSION['Nombre'] = $usuario['Nombre'];
                $_SESSION['Apellidos'] = $usuario['Ape_Paterno'] . ' ' . $usuario['Ape_Materno'];

                if ($usuario['TipoUsuario'] === 'Doctor') {
                    $queryDoctor = "SELECT DoctorId FROM Doctores WHERE UsuarioId = :usuarioId";
                    $stmtDoctor = Conexion::getInstancia()->getConexion()->prepare($queryDoctor);
                    $stmtDoctor->bindParam(':usuarioId', $usuario['UsuarioId'], PDO::PARAM_INT);
                    $stmtDoctor->execute();
                    $doctor = $stmtDoctor->fetch(PDO::FETCH_ASSOC);
                    if ($doctor) {
                        $_SESSION['DoctorId'] = $doctor['DoctorId'];
                    } else {
                        $_SESSION['error'] = 'No se pudo encontrar el ID del doctor.';
                        header('Location: ../presentacion/login.php');
                        exit();
                    }
                }

                switch ($usuario['TipoUsuario']) {
                    case 'Administrador':
                        header('Location: ../presentacion/home-administrador.php');
                        break;
                    case 'Asistente':
                        header('Location: ../presentacion/home-asistente.php');
                        break;
                    case 'Doctor':
                        header('Location: ../presentacion/home-doctor.php');
                        break;
                    default:
                        $_SESSION['error'] = 'No tienes permisos para acceder.';
                        header('Location: ../presentacion/login.php');
                }
                exit();
            }
        } else {
            $_SESSION['error'] = 'Código o contraseña incorrectos.';
            header('Location: ../presentacion/login.php');
            exit();
        }
    }
}
?>