FROM node:20 AS frontend
WORKDIR /app
COPY package*.json vite.config.js ./
COPY resources ./resources
RUN npm ci && npm run build

FROM php:8.2-apache AS base
RUN apt-get update && apt-get install -y \
    git zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev curl gnupg \
    && docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath gd zip \
    && a2enmod rewrite

WORKDIR /var/www/html
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . .
COPY --from=frontend /app/public/build ./public/build

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf /etc/apache2/apache2.conf

ENV APACHE_LISTEN_PORT=10000
RUN sed -ri "s/Listen 80/Listen ${APACHE_LISTEN_PORT}/g" /etc/apache2/ports.conf
EXPOSE 10000

RUN composer install --no-dev --optimize-autoloader
RUN chown -R www-data:www-data storage bootstrap/cache
RUN php artisan storage:link || true && \
    php artisan config:cache && php artisan route:cache && php artisan view:cache

CMD ["apache2-foreground"]