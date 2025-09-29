FROM php:8.1-apache

# Instalar extensiones necesarias para MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Copiar configuración personalizada de Apache
COPY ./apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Copiar el proyecto al contenedor
COPY . /var/www/html/
