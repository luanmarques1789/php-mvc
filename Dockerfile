FROM php:8.0-apache
RUN a2enmod rewrite && docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo pdo_mysql