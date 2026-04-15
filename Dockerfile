FROM php:8.2-cli

WORKDIR /app

# Dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev

# Extensiones PHP necesarias para Laravel
RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar archivos primero (IMPORTANTE)
COPY composer.json composer.lock ./

# Instalar dependencias PHP
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Copiar el resto del proyecto
COPY . .

# Permisos Laravel
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000
