FROM php:8.2-cli

WORKDIR /app

COPY . .

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    unzip git curl libzip-dev zip \
    && docker-php-ext-install pdo pdo_mysql zip

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# 👇 CLAVE: sin scripts
RUN composer install --no-dev --no-scripts --optimize-autoloader

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000
