FROM php:8.1-apache

# Instalar extensiones necesarias para MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilitar mod_rewrite (opcional, si usas rutas amigables)
RUN a2enmod rewrite

# Copiar el proyecto al contenedor
COPY . /var/www/html/
