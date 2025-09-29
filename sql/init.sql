CREATE DATABASE IF NOT EXISTS mi_basedatos;
USE mi_basedatos;

CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario VARCHAR(100) UNIQUE NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR (100) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    fecha_nacimiento TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO usuarios (nombre, correo, password) VALUES
('Juan Pérez', 'juan@example.com', '12345'),
('Ana Gómez', 'ana@example.com', 'abcdef');