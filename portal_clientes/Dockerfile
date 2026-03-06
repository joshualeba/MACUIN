FROM php:8.2-apache

RUN apt-get update -y && apt-get install -y libzip-dev zip unzip git \
    && docker-php-ext-install pdo_mysql zip

RUN a2enmod rewrite

# Actualizar el DocumentRoot a la carpeta public de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

# Ajustar los permisos
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
