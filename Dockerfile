# Usa la imagen oficial de PHP con Apache
FROM php:7.4-apache

# Instala extensiones necesarias para MySQL
RUN docker-php-ext-install mysqli

# Copia los archivos del proyecto al directorio raíz de Apache
COPY . /var/www/html/

# Establece los permisos adecuados
RUN chown -R www-data:www-data /var/www/html

# Expone el puerto 80
EXPOSE 80
