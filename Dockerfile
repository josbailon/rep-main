FROM php:8.1-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql \
    && a2enmod rewrite \
    && sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
