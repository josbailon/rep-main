FROM php:8.1-apache

# Instalar la extensión mysqli
RUN docker-php-ext-install mysqli

# Copiar tu código fuente (todo el proyecto) al contenedor
COPY . /var/www/html/

# Dar permisos adecuados
RUN chown -R www-data:www-data /var/www/html

# Habilitar módulos de Apache si los necesitas (opcional)
# RUN a2enmod rewrite
