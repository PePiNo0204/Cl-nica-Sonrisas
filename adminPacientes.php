<?php 
    include_once '../controladores/gestionarPacientes.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Pacientes</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/adminPacientes.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Administrar Pacientes</h1>
            <div class="search-bar">
                <form method="GET" action="">
                    <input type="text" name="search" placeholder="Buscar por DNI" value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <button class="add-patient-button" onclick="location.href='agregarPaciente.php'">
                <i class="fa fa-user-plus"></i> Agregar Paciente
            </button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>DNI</th>
                    <th>Teléfono</th>
                    <th>Estado</th>
                    <th>Detalle</th>
                    <th>Cambiar Estado</th>
                    <th>Ver Citas</th>
                    <th>Ver Historial</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pacientes)): ?>
                    <tr>
                        <td colspan="8">No se encontraron pacientes.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($pacientes as $paciente): ?>
                    <tr>
                        <td data-label="Nombre"><?php echo htmlspecialchars($paciente['Nombre']); ?></td>
                        <td data-label="DNI"><?php echo htmlspecialchars($paciente['DNI']); ?></td>
                        <td data-label="Teléfono"><?php echo htmlspecialchars($paciente['Telefono']); ?></td>
                        <td data-label="Estado">
                            <span class="<?php echo $paciente['Estado'] === 'Activo' ? 'active' : 'inactive'; ?>">
                                <?php echo htmlspecialchars($paciente['Estado']); ?>
                            </span>
                        </td>
                        <td data-label="Detalle">
                            <button onclick="viewDetail(<?php echo $paciente['PacienteId']; ?>)">
                                <i class="fa fa-eye" style="color: #40E0D0;"></i>
                            </button>
                        </td>
                        <td data-label="Estado">
                            <form method="POST" action="">
                                <input type="hidden" name="id" value="<?php echo $paciente['PacienteId']; ?>">
                                <input type="hidden" name="nuevoEstado" value="<?php echo $paciente['Estado'] === 'Activo' ? 'Inactivo' : 'Activo'; ?>">
                                <button type="submit" name="cambiarEstado">
                                    <i class="fa fa-sync" style="color: #FF6F61;"></i>
                                </button>
                            </form>
                        </td>
                        <td data-label="Ver Citas">
                            <button onclick="viewCitas(<?php echo $paciente['PacienteId']; ?>)">
                                <i class="fa fa-calendar" style="color: #40E0D0;"></i>
                            </button>
                        </td>
                        <td data-label="Ver Historial">
                            <button onclick="viewHistorial(<?php echo $paciente['PacienteId']; ?>)">
                                <i class="fa fa-history" style="color: #40E0D0;"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="./js/adminPacientes.js"></script>
</body>
</html>
