# Imagen base de Apache oficial
FROM httpd:2.4

# Copiar la configuración personalizada
COPY ./back/default.conf /usr/local/apache2/conf/httpd.conf

# Copiar todo el frontend a la carpeta pública
COPY ./frontend /usr/local/apache2/htdocs



