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

// Verificar si el ID de usuario se pasó en la URL
if (isset($_GET['id'])) {
    $usuarioId = $_GET['id'];

    // Obtener los datos del usuario para editar
    $query = "SELECT * FROM usuarios WHERE UsuarioId = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(1, $usuarioId, PDO::PARAM_INT);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        // Si no se encuentra el usuario, redirigir con un mensaje de error
        header('Location: adminUsuarios.php?error=Usuario no encontrado');
        exit();
    }
} else {
    // Si no se pasa el ID, redirigir con un mensaje de error
    header('Location: adminUsuarios.php?error=ID de usuario no especificado');
    exit();
}

// Procesar el formulario cuando se envíe
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    // Actualizar el usuario en la base de datos
    if (empty($contraseña)) {
        // Si la contraseña está vacía, no se actualiza
        $query = "UPDATE usuarios SET Codigo = ?, TipoUsuario = ?, Nombre = ?, Ape_Paterno = ?, Ape_Materno = ?, DNI = ?, Telefono = ?, Direccion = ?, Estado = ? WHERE UsuarioId = ?";
        $stmt = $conexion->prepare($query);
        $stmt->execute([$codigo, $tipo_usuario, $nombre, $ape_paterno, $ape_materno, $dni, $telefono, $direccion, $estado, $usuarioId]);
    } else {
        // Si la contraseña no está vacía, se actualiza la contraseña
        $query = "UPDATE usuarios SET Codigo = ?, Contraseña = ?, TipoUsuario = ?, Nombre = ?, Ape_Paterno = ?, Ape_Materno = ?, DNI = ?, Telefono = ?, Direccion = ?, Estado = ? WHERE UsuarioId = ?";
        $stmt = $conexion->prepare($query);
        $stmt->execute([$codigo, $contraseña, $tipo_usuario, $nombre, $ape_paterno, $ape_materno, $dni, $telefono, $direccion, $estado, $usuarioId]);
    }

    header('Location: adminUsuarios.php?success=Usuario actualizado correctamente');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/agregarUsuario.css">
    <style>
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            color: #000;
            cursor: pointer;
        }
        .close-btn:hover {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container" style="position: relative;">
        <!-- Botón para cerrar y regresar a adminUsuarios.php -->
        <a href="adminUsuarios.php" class="close-btn">&times;</a>

        <!-- Mensaje de error o éxito -->
        <?php if ($mensaje): ?>
        <div class="alert"><?php echo htmlspecialchars($mensaje); ?></div>
        <?php endif; ?>

        <h1>Editar Usuario</h1>

        <form action="editarUsuario.php?id=<?php echo $usuario['UsuarioId']; ?>" method="POST">
            <div class="form-group">
                <label for="codigo">Código</label>
                <input type="text" id="codigo" name="codigo" value="<?php echo htmlspecialchars($usuario['Codigo']); ?>" required>
            </div>

            <div class="form-group">
                <label for="contraseña">Contraseña</label>
                <input type="password" id="contraseña" name="contraseña" placeholder="Deja vacío si no deseas cambiarla">
            </div>

            <div class="form-group">
                <label for="tipo_usuario">Tipo de Usuario</label>
                <select id="tipo_usuario" name="tipo_usuario" required>
                    <option value="Administrador" <?php echo ($usuario['TipoUsuario'] === 'Administrador') ? 'selected' : ''; ?>>Administrador</option>
                    <option value="Asistente" <?php echo ($usuario['TipoUsuario'] === 'Asistente') ? 'selected' : ''; ?>>Asistente</option>
                    <option value="Doctor" <?php echo ($usuario['TipoUsuario'] === 'Doctor') ? 'selected' : ''; ?>>Doctor</option>
                </select>
            </div>

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['Nombre']); ?>" required>
            </div>

            <div class="form-group">
                <label for="ape_paterno">Apellido Paterno</label>
                <input type="text" id="ape_paterno" name="ape_paterno" value="<?php echo htmlspecialchars($usuario['Ape_Paterno']); ?>" required>
            </div>

            <div class="form-group">
                <label for="ape_materno">Apellido Materno</label>
                <input type="text" id="ape_materno" name="ape_materno" value="<?php echo htmlspecialchars($usuario['Ape_Materno']); ?>" required>
            </div>

            <div class="form-group">
                <label for="dni">DNI</label>
                <input type="text" id="dni" name="dni" value="<?php echo htmlspecialchars($usuario['DNI']); ?>" required>
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($usuario['Telefono']); ?>" required>
            </div>

            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($usuario['Direccion']); ?>" required>
            </div>

            <div class="form-group">
                <label for="estado">Estado</label>
                <select id="estado" name="estado" required>
                    <option value="Activo" <?php echo ($usuario['Estado'] === 'Activo') ? 'selected' : ''; ?>>Activo</option>
                    <option value="Inactivo" <?php echo ($usuario['Estado'] === 'Inactivo') ? 'selected' : ''; ?>>Inactivo</option>
                </select>
            </div>

            <button type="submit">Guardar Cambios</button>
        </form>
    </div>
</body>
</html>
