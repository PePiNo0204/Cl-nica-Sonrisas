// Función para mostrar el cuadro de confirmación
function showConfirmDialog() {
    document.getElementById('confirmContainer').style.display = 'flex';
}

// Función para cerrar el cuadro de confirmación
function closeConfirmDialog() {
    document.getElementById('confirmContainer').style.display = 'none';
}

// Función para mostrar un mensaje personalizado
function showMessage(content) {
    document.getElementById('messageContent').textContent = content;
    document.getElementById('messageContainer').style.display = 'flex';
}

// Función para cerrar el cuadro de mensaje
function closeMessage() {
    document.getElementById('messageContainer').style.display = 'none';
}

// Función para guardar cambios (redirecciona a otra página)
function guardarCambios() {
    closeConfirmDialog(); // Cierra el cuadro de confirmación
    showMessage("Guardando los cambios...");
    setTimeout(() => {
        window.location.href = "adminUsuarios.php"; // Cambia "paginaDestino.php" por la URL deseada
    }, 2000);
}

// Función para cancelar la acción
function cancelar() {
    closeConfirmDialog(); // Cierra el cuadro de confirmación
    showMessage("No se guardaron los cambios.");
}

// Función para cerrar el cuadro de alerta
function closeAlert() {
    document.getElementById('alertContainer').style.display = 'none';
}
