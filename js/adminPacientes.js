// Función para ver el detalle de un paciente
function viewDetail(id) {
    window.location.href = `detallePaciente.php?id=${id}`;
}

// Función para ver las citas de un paciente
function viewCitas(id) {
    window.location.href = `detalleCitas.php?id=${id}`;
}

// Función para ver el historial de un paciente
function viewHistorial(id) {
    window.location.href = `historialPaciente.php?id=${id}`;
}
