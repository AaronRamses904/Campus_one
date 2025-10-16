// 📌 Escucha el evento de envío del formulario
document.getElementById("registroForm").addEventListener("submit", async (e) => {
  e.preventDefault(); // Evita que la página se recargue automáticamente

  // 📌 Tomar los valores del formulario
  const data = {
    nombre: document.getElementById("nombre").value,
    apellido: document.getElementById("apellido").value,
    fecha_nacimiento: document.getElementById("fecha_nacimiento").value,
    correo: document.getElementById("correo").value,
    id_usuario: document.getElementById("id_usuario").value,
    password: document.getElementById("password").value
  };

  try {
    // 📌 Enviar datos al backend Node.js
    const response = await fetch("http://localhost:8083/register", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data)
    });

    if (response.ok) {
      alert("✅ Registro exitoso");
      window.location.href = "index.html"; // Redirigir a login
    } else {
      const errorData = await response.json();
      alert("❌ Error: " + (errorData.message || "No se pudo registrar"));
    }
  } catch (error) {
    console.error("Error:", error);
    alert("⚠️ No se pudo conectar con el servidor");
  }
});
