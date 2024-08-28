FROM php:8.1-apache

# Instalar las extensiones de PHP necesarias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Copiar el código de la aplicación al contenedor
COPY . /var/www

# Exponer el puerto 80 para el tráfico web
EXPOSE 80
