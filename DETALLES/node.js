// Función para alternar la visibilidad del texto
function toggleText(element) {
    element.classList.toggle('active');
  }
  
  // Actualizar el año en el pie de página
  document.getElementById('current-year').textContent = new Date().getFullYear();
  