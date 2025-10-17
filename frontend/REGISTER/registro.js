const form = document.getElementById("form-registro");

form.addEventListener("submit", async (e) => {
  e.preventDefault();

  const data = {
    nombre: document.getElementById("nombre").value.trim(),
    apellido: document.getElementById("apellido").value.trim(),
    fecha_nacimiento: document.getElementById("fecha_nacimiento").value,
    correo: document.getElementById("correo").value.trim(),
    id_usuario: document.getElementById("id_usuario").value.trim(),
    password: document.getElementById("password").value.trim()
  };

  console.log("Datos a enviar:", data); //  Depuración

  try {
    const response = await fetch("http://localhost:8084/registro", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data)
    });

    const result = await response.json();
    if (response.ok) {
      alert("✅ " + result.mensaje);
      window.location.href = "/index.html"; // Redirige al login después de registrar
    } else {
      alert("❌ " + (result.error || "No se pudo registrar"));
    }
  } catch (error) {
    console.error("Error:", error);
    alert("⚠️ No se pudo conectar con el servidor");
  }
});




