FROM node:20 AS frontend
WORKDIR /app
COPY package*.json vite.config.js ./
COPY resources ./resources
RUN npm ci && npm run build

FROM php:8.2-apache
RUN apt-get update && apt-get install -y git zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev curl gnupg \
    && docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath gd zip \
    && a2enmod rewrite env

WORKDIR /var/www/html
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . .
COPY --from=frontend /app/public/build ./public/build

ENV APACHE_LISTEN_PORT=10000
RUN sed -ri "s/Listen 80/Listen ${APACHE_LISTEN_PORT}/g" /etc/apache2/ports.conf
RUN echo "<VirtualHost *:${APACHE_LISTEN_PORT}>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
    SetEnv APP_KEY \${APP_KEY}\n\
    SetEnv APP_ENV \${APP_ENV}\n\
    SetEnv APP_DEBUG \${APP_DEBUG}\n\
    SetEnv DB_CONNECTION \${DB_CONNECTION}\n\
    SetEnv DB_HOST \${DB_HOST}\n\
    SetEnv DB_PORT \${DB_PORT}\n\
    SetEnv DB_DATABASE \${DB_DATABASE}\n\
    SetEnv DB_USERNAME \${DB_USERNAME}\n\
    SetEnv DB_PASSWORD \${DB_PASSWORD}\n\
    ErrorLog \${APACHE_LOG_DIR}/error.log\n\
    CustomLog \${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>" > /etc/apache2/sites-available/000-default.conf

EXPOSE 10000

RUN composer install --no-dev --optimize-autoloader
RUN chown -R www-data:www-data storage bootstrap/cache
RUN php artisan config:clear && php artisan route:cache && php artisan view:cache

CMD ["apache2-foreground"]