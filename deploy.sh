#!/usr/bin/env bash
set -e

# Wait for PostgreSQL to be ready
until php -r "new PDO('pgsql:host=${DB_HOST};port=${DB_PORT};dbname=${DB_DATABASE}', '${DB_USERNAME}', '${DB_PASSWORD}');" 2>/dev/null; do
  echo "Waiting for database..."
  sleep 3
done

php artisan migrate --force
php artisan config:cache || true
php artisan route:cache || true

php-fpm