document.addEventListener("DOMContentLoaded", () => {
    // Selección de elementos
    const iframe = document.getElementById("content-area");
    const links = document.querySelectorAll(".menu-links a");
    const sidebarToggle = document.querySelector(".toggle");
    const sidebar = document.querySelector(".sidebar");
    const menuLinks = document.querySelectorAll(".menu-links a .text");
    
    // Función para aplicar la animación 3D al iframe
    function apply3DAnimation() {
        // Agregar la clase 3D al iframe
        iframe.classList.add("animate-3d");

        // Esperar un poco para quitar la clase de animación
        setTimeout(() => {
            iframe.classList.remove("animate-3d");
        }, 300); // Duración de la animación (0.3s)
    }

    // Cambiar el contenido del iframe y aplicar animación 3D al hacer clic en los enlaces del menú
    links.forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault(); // Prevenir el comportamiento por defecto (cargar la página)

            // Obtener el href del enlace (página a cargar)
            const page = link.getAttribute("href");

            // Actualizar el iframe con la nueva página
            iframe.src = page;

            // Aplicar animación 3D
            apply3DAnimation();
        });
    });

    // Alternar el estado colapsado del sidebar y cambiar el texto del menú por iconos
    sidebarToggle.addEventListener("click", () => {
        sidebar.classList.toggle("collapsed"); // Alterna entre colapsado y expandido

        // Cambiar la visibilidad de los textos de los enlaces
        menuLinks.forEach(text => {
            text.classList.toggle("hidden"); // Agregar o quitar la clase 'hidden' en los textos
        });
    });
});
