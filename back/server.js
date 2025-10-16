const express = require("express");
const mongoose = require("mongoose");
const dotenv = require("dotenv");
const cors = require("cors");
const bodyParser = require("body-parser");

dotenv.config();
const app = express();

app.use(cors());
app.use(bodyParser.json());

mongoose.connect(process.env.MONGO_URI)
  .then(() => console.log("✅ Conectado a MongoDB Atlas"))
  .catch(err => console.error("❌ Error de conexión:", err));

const userSchema = new mongoose.Schema({
  id_usuario: { type: String, required: true, unique: true },
  password: { type: String, required: true },
  nombre: String,
  apellido: String,
  fecha_nacimiento: String,
  correo: String
});

const Usuario = mongoose.model("Usuario", userSchema);

app.post("/registro", async (req, res) => {
  try {
    const nuevo = new Usuario(req.body);
    await nuevo.save();
    res.status(200).json({ mensaje: "Usuario registrado correctamente ✅" });
  } catch (err) {
    res.status(400).json({ error: "No se pudo registrar: " + err });
  }
});

app.post("/login", async (req, res) => {
  const { id_usuario, password } = req.body;
  const user = await Usuario.findOne({ id_usuario, password });
  if (!user) {
    return res.status(401).json({ error: "Credenciales incorrectas ❌" });
  }
  res.status(200).json({ mensaje: "Inicio de sesión exitoso ✅", user });
});

const PORT = process.env.PORT || 8083;
app.listen(PORT, () => console.log(`🚀 Servidor escuchando en puerto ${PORT}`));

