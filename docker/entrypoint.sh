#!/bin/sh
set -e

cd /var/www/html

# Ajusta permissões
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Rodar migrations só se o arquivo artisan existir
if [ -f artisan ]; then
    echo "Rodando migrations..."
    php artisan migrate --force

    echo "Cacheando configuração e rotas..."
    php artisan config:cache
    php artisan route:cache
else
    echo "Arquivo artisan não encontrado, pulando migrations..."
fi

# Inicia PHP-FPM
exec "$@"
