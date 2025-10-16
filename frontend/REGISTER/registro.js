const form = document.getElementById("form-registro");

form.addEventListener("submit", async (e) => {
  e.preventDefault();

  const data = {
    nombre: document.getElementById("nombre").value,
    apellido: document.getElementById("apellido").value,
    fecha_nacimiento: document.getElementById("fecha_nacimiento").value,
    correo: document.getElementById("correo").value,
    id_usuario: document.getElementById("id_usuario").value,
    password: document.getElementById("password").value
  };

  try {
    // ✅ Cambié mi_backend_node por localhost:8084
    const response = await fetch("http://localhost:8084/registro", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data)
    });

    if (response.ok) {
      alert("✅ Registro exitoso");
      window.location.href = "/principal.html"; // Redirige después de registrar
    } else {
      const errorData = await response.json();
      alert("❌ Error: " + (errorData.message || "No se pudo registrar"));
    }
  } catch (error) {
    console.error("Error:", error);
    alert("⚠️ No se pudo conectar con el servidor");
  }
});



