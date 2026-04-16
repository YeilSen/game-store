FROM php:8.4-cli

WORKDIR /app

COPY . .

RUN apt-get update && apt-get install -y \
    unzip git curl libzip-dev zip \
    && docker-php-ext-install zip pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

RUN php artisan config:clear

# 🔥 permisos importantes
RUN chmod -R 777 storage bootstrap/cache

EXPOSE 10000

# 🔥 CAMBIO CLAVE
CMD php -S 0.0.0.0:10000 -t public