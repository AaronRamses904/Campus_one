''''bash
docker-compose up --build
dcoker-compose build ''''

## Base de datos

Este proyecto usa **MySQL** como base de datos.  
La base se crea automáticamente con Docker (`mi_basedatos`), y las tablas se generan a partir del archivo [`sql/tablas.sql`](./sql/tabla.sql).

### Tabla: `usuarios`
sql
CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario VARCHAR (50) UNIQUE NOT NULL,
    nombre VARCHAR (50) NOT NULL,
    email VARCHAR (50) UNIQUE NOT NULL,
    password VARCHAR (255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);




