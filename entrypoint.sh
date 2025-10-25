#!/usr/bin/env bash
set -e

: "${PORT:=10000}"
echo "Listen ${PORT}" > /etc/apache2/ports.conf

cat >/etc/apache2/sites-available/000-default.conf <<EOF
<VirtualHost *:${PORT}>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html/public

    <Directory /var/www/html/public>
        AllowOverride All
        Require all granted
        Options FollowSymLinks
    </Directory>

    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOF

if [ -z "${APP_KEY}" ]; then
  echo "ERROR: APP_KEY no está definido. Configúralo en Render antes de iniciar."
  exit 1
fi

php artisan storage:link || true
php artisan migrate --force
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec apache2-foreground