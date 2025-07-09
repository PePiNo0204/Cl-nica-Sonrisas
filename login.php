<?php
session_start();


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="css/login.css">
    <style>
        .hidden {
            display: none;
        }
        .toggle {
            display: inline-block;
            margin-top: 15px;
            cursor: pointer;
            color:rgb(3, 3, 3);
            text-decoration: underline;
            text-align: center;
            width: 100%;
            
        }
    </style>
</head>
<body>
    <div class="login-container">
        <form action="../controladores/validarLogin.php" method="POST">
            <h1>Inicio de Sesión</h1>

            <!-- Mostrar mensajes de error -->
            <?php
            if (isset($_SESSION['error'])) {
                echo "<p class='error-message'>" . $_SESSION['error'] . "</p>";
                unset($_SESSION['error']);
            }
            ?>

            <!-- Bloque login normal -->
            <div id="usuarioLogin">
                <label for="codigo">Código:</label>
                <input type="text" id="codigo" name="codigo">

                <label for="contraseña">Contraseña:</label>
                <input type="password" id="contraseña" name="contraseña">
            </div>

            <!-- Bloque login paciente -->
            <div id="pacienteLogin" class="hidden">
                <label for="dni">DNI:</label>
                <input type="text" id="dni" name="dni" placeholder="Ingrese su DNI">
            </div>

            <button type="submit">Ingresar</button>

            <span class="toggle" id="togglePaciente">¿Eres paciente? Haz clic aquí</span>
        </form>
    </div>

    <script>
        const toggleLink = document.getElementById('togglePaciente');
        const usuarioLogin = document.getElementById('usuarioLogin');
        const pacienteLogin = document.getElementById('pacienteLogin');

        toggleLink.addEventListener('click', function() {
            usuarioLogin.classList.toggle('hidden');
            pacienteLogin.classList.toggle('hidden');

            if (pacienteLogin.classList.contains('hidden')) {
                toggleLink.textContent = "¿Eres paciente? Haz clic aquí";
            } else {
                toggleLink.textContent = "¿Volver a login normal?";
            }
        });
    </script>
</body>
</html>