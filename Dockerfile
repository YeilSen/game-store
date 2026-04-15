FROM php:8.2-cli

WORKDIR /app

COPY . .

RUN apt-get update && apt-get install -y \
    unzip git curl libzip-dev zip libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip mbstring xml

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000
