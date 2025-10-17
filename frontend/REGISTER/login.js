const form = document.getElementById("form-login");

form.addEventListener("submit", async (e) => {
  e.preventDefault();

  const data = {
    id_usuario: document.getElementById("id_usuario").value.trim(),
    password: document.getElementById("password").value.trim()
  };

  console.log("Datos enviados al login:", data); // Depuración

  try {
    const response = await fetch("http://localhost:8084/login", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data)
    });

    const result = await response.json();
    if (response.ok) {
      alert("✅ " + result.mensaje);
      //  Redirigir a inicio.html después del login
      window.location.href = "../inicio.html";
    } else {
      alert("❌ " + (result.error || "Usuario o contraseña incorrectos"));
    }
  } catch (error) {
    console.error("Error al conectar con el servidor:", error);
    alert("⚠️ Error de conexión con el servidor.");
  }
});







