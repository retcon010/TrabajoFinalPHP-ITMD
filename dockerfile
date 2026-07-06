# Imagen oficial de PHP con Apache
FROM php:8.2-apache

# Actualizamos los paquetes del sistema base para corregir vulnerabilidades conocidas
RUN apt-get update && apt-get upgrade -y && rm -rf /var/lib/apt/lists/*

# Instalamos la extensión mysqli para conectar con MySQL
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Habilitamos el módulo rewrite de Apache
RUN a2enmod rewrite

# Copiamos todos los archivos de nuestro proyecto al contenedor
COPY . /var/www/html/

# Ajustamos permisos para que Apache pueda leer los archivos
RUN chown -R www-data:www-data /var/www/html/

# Exponemos el puerto 80
EXPOSE 80