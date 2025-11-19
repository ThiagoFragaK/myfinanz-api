#!/bin/sh
set -e

# Ajusta permissões
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Espera um pouco para garantir que o DB esteja pronto (opcional)
# sleep 5

# Roda migrations automaticamente
echo "Rodando migrations..."
php artisan migrate --force

# Opcional: cache config e rotas para produção
php artisan config:cache
php artisan route:cache

# Inicia PHP-FPM
exec "$@"
