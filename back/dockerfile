# Imagen base de Node.js
FROM node:18

# Directorio de trabajo
WORKDIR /usr/src/app

# Copiar e instalar dependencias
COPY package*.json ./
RUN npm install

# Copiar el resto del código del backend
COPY . .

# Exponer el puerto del servidor Express
EXPOSE 8084

# Comando de inicio
CMD ["node", "server.js"]




