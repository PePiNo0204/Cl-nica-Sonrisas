<?php 
    include_once '../controladores/gestionarCitas.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Citas</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/adminCita.css">
    <link rel="stylesheet" href="./css/modal.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Administrar Citas</h1>
            <div class="search-bar">
                <form method="GET" action="">
                    <input type="text" name="search" placeholder="Buscar por DNI del paciente" value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <button class="add-appointment-button" onclick="location.href='Citas.php'">
                <i class="fa fa-calendar-plus"></i> Agregar Cita
            </button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Paciente</th>
                    <th>Doctor</th>
                    <th>Estado</th>
                    <th>Notas</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($citas)): ?>
                    <tr>
                        <td colspan="7">No se encontraron citas.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($citas as $cita): ?>
                    <tr>
                        <td data-label="Fecha"><?php echo htmlspecialchars($cita['Fecha']); ?></td>
                        <td data-label="Hora"><?php echo htmlspecialchars($cita['Hora']); ?></td>
                        <td data-label="Paciente"><?php echo htmlspecialchars($cita['PacienteNombre'] . " " . $cita['PacienteApellido']); ?></td>
                        <td data-label="Doctor"><?php echo htmlspecialchars($cita['DoctorNombre'] . " " . $cita['DoctorApellido']); ?></td>
                        <td data-label="Estado">
                            <?php echo htmlspecialchars($cita['Estado']); ?>
                            <!-- Botón para cambiar estado con icono -->
                            <button onclick="mostrarFormularioEstado(<?php echo $cita['CitaId']; ?>)" title="Cambiar Estado">
                                <i class="fa fa-pencil-alt"></i> Cambiar Estado
                            </button>
                        </td>
                        <td data-label="Notas"><?php echo htmlspecialchars($cita['Notas']); ?></td>
                        <td data-label="Opciones">
                            <!-- Botón Ver Detalle -->
                            <button onclick="editarCita(<?php echo $cita['CitaId']; ?>)" title="editar cita">
                                <i class="fa fa-eye" style="color:rgb(0, 0, 0);"></i>
                            </button>
                            <!-- Botón Eliminar -->
                            <button onclick="confirmarEliminacion(<?php echo $cita['CitaId']; ?>)" title="Eliminar">
                                <i class="fa fa-trash" style="color:rgb(12, 12, 12);"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Formulario flotante para cambiar estado -->
        <div id="formularioEstado" class="formularioEstado" style="display: none;">
            <form method="POST" action="">
                <label for="estado">Estado:</label>
                <select name="estado" required>
                    <option value="Agendada">Agendada</option>
                    <option value="Cancelada">Cancelada</option>
                    <option value="Completada">Completada</option>
                </select>
                <input type="hidden" name="id" id="citaId">
                <button type="submit" name="cambiar_estado">Cambiar Estado</button>
                <button type="button" onclick="cerrarFormularioEstado()">Cerrar</button>
            </form>
        </div>
    </div>

    <script src="./js/adminCitas.js"></script>
</body>
</html>
