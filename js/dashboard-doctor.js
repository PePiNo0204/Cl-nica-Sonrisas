// Crear un observer para detectar cuando las tarjetas son visibles
const observer = new IntersectionObserver((entries, observer) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      // Cuando la tarjeta es visible, añadimos la clase "animate"
      entry.target.classList.add('animate');
      observer.unobserve(entry.target); // Deja de observar una vez que la tarjeta es visible
    }
  });
}, { threshold: 0.5 }); // Se activa cuando el 50% de la tarjeta es visible

// Seleccionar todas las tarjetas
const cards = document.querySelectorAll('.article-wrapper');

// Iniciar el observer en cada tarjeta
cards.forEach(card => {
  observer.observe(card);
});
