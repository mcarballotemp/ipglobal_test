FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
        libzip-dev \
        zip \
    && docker-php-ext-install \
        zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . . 

RUN chown -R www-data:www-data /var/www /var/www/html

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer install --no-dev --optimize-autoloader

RUN php bin/console assets:install public

RUN chown -R www-data:www-data /var/www /var/www/html

EXPOSE 9000
