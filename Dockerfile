FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    zip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev

RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar primero SOLO composer
COPY composer.json composer.lock ./

# Debug opcional (para ver error real)
RUN composer validate

# Instalar dependencias
RUN composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader

COPY . .

RUN chmod -R 775 storage bootstrap/cache

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000
