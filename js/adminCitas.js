// Función para editar una cita
function editarCita(id) {
    window.location.href = `editCita.php?id=${id}`;
}

// Función para mostrar el formulario de cambio de estado
function mostrarFormularioEstado(citaId) {
    document.getElementById('citaId').value = citaId;
    document.getElementById('formularioEstado').style.display = 'block'; // Mostrar formulario
}

// Función para cerrar el formulario de cambio de estado
function cerrarFormularioEstado() {
    document.getElementById('formularioEstado').style.display = 'none'; // Ocultar formulario
}

// Función para confirmar la eliminación de una cita
function confirmarEliminacion(citaId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '';
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'eliminar';
            input.value = true;
            form.appendChild(input);
            var inputId = document.createElement('input');
            inputId.type = 'hidden';
            inputId.name = 'id';
            inputId.value = citaId;
            form.appendChild(inputId);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
