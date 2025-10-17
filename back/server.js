// Importar dependencias
const express = require("express");
const mongoose = require("mongoose");
const dotenv = require("dotenv");
const cors = require("cors");
const bodyParser = require("body-parser");

// Cargar variables de entorno
dotenv.config();
const app = express();

//  Middlewares
app.use(cors());
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true })); // para formularios por si acaso

// Conexión a MongoDB Atlas
mongoose.connect(process.env.MONGO_URI)
  .then(() => console.log("✅ Conectado a MongoDB Atlas"))
  .catch(err => console.error(" Error de conexión:", err));

//  Definir esquema y modelo de usuario
const userSchema = new mongoose.Schema({
  id_usuario: { type: String, required: true, unique: true },
  password: { type: String, required: true },
  nombre: String,
  apellido: String,
  fecha_nacimiento: String,
  correo: String
});

const Usuario = mongoose.model("Usuario", userSchema);

//  Ruta para registrar usuario
app.post("/registro", async (req, res) => {
  console.log("Datos recibidos en /registro:", req.body); // 🔹 Depuración
  try {
    const nuevo = new Usuario(req.body);
    await nuevo.save();
    console.log("👤 Usuario registrado:", nuevo.id_usuario);
    res.status(200).json({ mensaje: "Usuario registrado correctamente " });
  } catch (err) {
    console.error(" Error al registrar:", err.message);
    res.status(400).json({ error: "No se pudo registrar: " + err.message });
  }
});

//  Ruta para iniciar sesión
app.post("/login", async (req, res) => {
  console.log("Datos recibidos en /login:", req.body); // 🔹 Depuración
  try {
    const { id_usuario, password } = req.body;
    const user = await Usuario.findOne({ id_usuario, password });

    if (!user) {
      console.warn(" Intento de login fallido:", id_usuario);
      return res.status(401).json({ error: "Credenciales incorrectas " });
    }

    console.log(" Inicio de sesión exitoso:", user.id_usuario);
    res.status(200).json({ mensaje: "Inicio de sesión exitoso ", user });
  } catch (error) {
    console.error(" Error en /login:", error);
    res.status(500).json({ error: "Error interno del servidor" });
  }
});

//  Iniciar servidor
const PORT = process.env.PORT || 8084;
app.listen(PORT, "0.0.0.0", () => {
  console.log(` Servidor escuchando en puerto ${PORT}`);
});



