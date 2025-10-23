FROM node:20 AS frontend
WORKDIR /app
COPY package*.json vite.config.js ./
COPY resources ./resources
RUN npm ci && npm run build

FROM php:8.2-apache
RUN apt-get update && apt-get install -y git zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev curl gnupg \
    && docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath gd zip \
    && a2enmod rewrite

WORKDIR /var/www/html
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . .
COPY --from=frontend /app/public/build ./public/build

ENV APACHE_LISTEN_PORT=10000
RUN sed -ri "s/Listen 80/Listen ${APACHE_LISTEN_PORT}/g" /etc/apache2/ports.conf
RUN bash -lc 'cat >/etc/apache2/sites-available/000-default.conf <<EOF
<VirtualHost *:${APACHE_LISTEN_PORT}>
    DocumentRoot /var/www/html/public
    <Directory /var/www/html/public>
        AllowOverride All
        Require all granted
    </Directory>
    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOF'
EXPOSE 10000

RUN composer install --no-dev --optimize-autoloader
RUN chown -R www-data:www-data storage bootstrap/cache
RUN php artisan storage:link || true && php artisan config:cache && php artisan route:cache && php artisan view:cache

CMD ["apache2-foreground"]