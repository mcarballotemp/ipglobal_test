FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
        libzip-dev \
        zip \
    && docker-php-ext-install \
        zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . . 

RUN cp phpstan.dist.neon phpstan.neon

RUN chown -R www-data:www-data /var/www /var/www

USER www-data

RUN composer install --optimize-autoloader

USER root

RUN chown -R www-data:www-data /var/www

EXPOSE 9000
