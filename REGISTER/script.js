document.getElementById('loginForm').addEventListener('submit', function (e) {
  e.preventDefault();

  const usuario = document.getElementById('usuario').value.trim();
  const password = document.getElementById('password').value;

  const usuarioRegistrado = JSON.parse(localStorage.getItem('usuarioRegistrado'));

  if (!usuarioRegistrado) {
    alert('No hay usuarios registrados aún. Regístrate primero.');
    return;
  }

  if (usuario === usuarioRegistrado.gmail && password === usuarioRegistrado.password) {
    alert(`Bienvenido, ${usuarioRegistrado.nombre} ${usuarioRegistrado.apellido}`);
    // Puedes redirigir al usuario
  } else {
    alert('Usuario o contraseña incorrectos');
  }
});




