document.addEventListener('DOMContentLoaded', () => {
    const events = document.querySelectorAll('.event');
    const detalleCitaContainer = document.getElementById('detalle-cita');

    let timeout;

    events.forEach(event => {
        const citaId = event.getAttribute('data-cita-id');

        event.addEventListener('mouseenter', () => {
            // Cancelar cualquier timeout anterior para ocultar
            clearTimeout(timeout);

            fetch(`detalleCita.php?citaId=${citaId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        detalleCitaContainer.innerHTML = `<div class="error">${data.error}</div>`;
                    } else {
                        detalleCitaContainer.innerHTML = `
                            <div class="detalle-cita">
                                <h2>Detalles de la Cita</h2>
                                <p><strong>Fecha:</strong> ${data.Fecha}</p>
                                <p><strong>Hora:</strong> ${data.Hora}</p>
                                <p><strong>Notas:</strong> ${data.Notas}</p>
                                <h3>Información del Paciente</h3>
                                <p><strong>Nombre:</strong> ${data.PacienteNombre} ${data.PacienteApellidoPaterno} ${data.PacienteApellidoMaterno}</p>
                                <p><strong>DNI:</strong> ${data.PacienteDNI}</p>
                                <p><strong>Fecha de Nacimiento:</strong> ${data.PacienteFechaNacimiento}</p>
                                <p><strong>Teléfono:</strong> ${data.PacienteTelefono}</p>
                                <p><strong>Dirección:</strong> ${data.PacienteDireccion}</p>
                                <p><strong>Sexo:</strong> ${data.PacienteSexo}</p>
                            </div>
                        `;
                        detalleCitaContainer.style.display = 'block';

                        // Posicionar cerca del cursor (opcional: ajustar según necesidad)
                        const rect = event.getBoundingClientRect();
                        detalleCitaContainer.style.top = `${rect.top + window.scrollY + 20}px`;
                        detalleCitaContainer.style.left = `${rect.right + 10}px`;
                    }
                })
                .catch(error => {
                    console.error('Error al cargar los detalles:', error);
                    detalleCitaContainer.innerHTML = `<div class="error">Ocurrió un error al cargar los detalles.</div>`;
                    detalleCitaContainer.style.display = 'block';
                });
        });

        // Ocultar cuando se quita el cursor del evento
        event.addEventListener('mouseleave', () => {
            timeout = setTimeout(() => {
                detalleCitaContainer.style.display = 'none';
                detalleCitaContainer.innerHTML = '';
            }, 300); // Pequeña demora para permitir pasar al detalle
        });
    });

    // Evitar que desaparezca si el usuario entra al cuadro de detalle
    detalleCitaContainer.addEventListener('mouseenter', () => {
        clearTimeout(timeout);
    });

    // Ocultar si el usuario sale del cuadro de detalle
    detalleCitaContainer.addEventListener('mouseleave', () => {
        detalleCitaContainer.style.display = 'none';
        detalleCitaContainer.innerHTML = '';
    });
});
