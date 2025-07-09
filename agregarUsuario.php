<?php
require_once '../dao/UsuarioDAO.php';

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recogemos los datos del formulario
    $codigo = $_POST['codigo'];
    $contraseña = $_POST['contraseña'];  // Contraseña en texto plano
    $tipo_usuario = $_POST['tipo_usuario'];
    $nombre = $_POST['nombre'];
    $ape_paterno = $_POST['ape_paterno'];
    $ape_materno = $_POST['ape_materno'];
    $dni = $_POST['dni'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $estado = $_POST['estado'];

    // Validaciones básicas
    if (empty($codigo) || empty($contraseña) || empty($tipo_usuario) || empty($nombre) || empty($ape_paterno) || empty($ape_materno) || empty($dni)) {
        $error = "Todos los campos marcados con * son obligatorios.";
    } elseif (!is_numeric($dni) || strlen($dni) !== 8) {
        $error = "El DNI debe contener exactamente 8 dígitos numéricos.";
    } elseif (!empty($telefono) && (!is_numeric($telefono) || strlen($telefono) !== 9)) {
        $error = "El teléfono debe contener exactamente 9 dígitos numéricos.";
    } else {
        // Crear una instancia de UsuarioDAO para agregar el nuevo usuario
        $usuarioDAO = new UsuarioDAO();

        // Llamamos al método para agregar el usuario a la base de datos
        $result = $usuarioDAO->agregarUsuario($codigo, $contraseña, $tipo_usuario, $nombre, $ape_paterno, $ape_materno, $dni, $telefono, $direccion, $estado);

        if ($result === true) {
            $success = "Usuario agregado exitosamente.";
        } else {
            $error = "Error al agregar el usuario: " . $result;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/agregarUsuario.css">
    <title>Agregar Usuario</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <div class="form-header">
            <button class="close-btn" onclick="confirmExit()">&times;</button>
        </div>
        <h1>Agregar Usuario</h1>
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <label for="codigo">Código *</label>
            <input type="text" name="codigo" id="codigo" required>

            <label for="contraseña">Contraseña *</label>
            <input type="password" name="contraseña" id="contraseña" required>

            <label for="tipo_usuario">Tipo de Usuario *</label>
            <select name="tipo_usuario" id="tipo_usuario" required>
                <option value="Administrador">Administrador</option>
                <option value="Asistente">Asistente</option>
                <option value="Doctor">Doctor</option>
            </select>

            <label for="nombre">Nombre *</label>
            <input type="text" name="nombre" id="nombre" required>

            <label for="ape_paterno">Apellido Paterno *</label>
            <input type="text" name="ape_paterno" id="ape_paterno" required>

            <label for="ape_materno">Apellido Materno *</label>
            <input type="text" name="ape_materno" id="ape_materno" required>

            <label for="dni">DNI *</label>
            <input type="text" name="dni" id="dni" maxlength="8" required onkeypress="allowNumbersOnly(event)">

            <label for="telefono">Teléfono</label>
            <input type="text" name="telefono" id="telefono" maxlength="9" onkeypress="allowNumbersOnly(event)">

            <label for="direccion">Dirección</label>
            <input type="text" name="direccion" id="direccion">

            <label for="estado">Estado *</label>
            <select name="estado" id="estado" required>
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
            </select>

            <button type="submit">Agregar Usuario</button>
        </form>
    </div>

    <script>
        function confirmExit() {
            Swal.fire({
                title: "¿Estás seguro de que deseas salir?",
                text: "Todos los cambios no guardados se perderán.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, salir",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "adminUsuarios.php";
                }
            });
        }

        function allowNumbersOnly(event) {
            const charCode = event.which ? event.which : event.keyCode;
            if (charCode < 48 || charCode > 57) {
                event.preventDefault();
            }
        }
    </script>
</body>
</html>
