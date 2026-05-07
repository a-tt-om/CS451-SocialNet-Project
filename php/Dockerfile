FROM php:8.2-fpm

# Install MySQL PDO extension
RUN docker-php-ext-install pdo pdo_mysql mysqli

WORKDIR /var/www/html

EXPOSE 9000
