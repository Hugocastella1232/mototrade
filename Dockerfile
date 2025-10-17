FROM php:8.2-apache
RUN apt-get update && apt-get install -y git zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip
COPY . /var/www/html
WORKDIR /var/www/html
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader
EXPOSE 10000
CMD php artisan serve --host=0.0.0.0 --port=10000