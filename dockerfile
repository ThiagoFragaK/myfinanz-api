# ============================
# 1) Build Stage
# ============================
FROM composer:2 AS build

WORKDIR /app

# Copia apenas composer.json e composer.lock para usar cache do composer
COPY composer.json composer.lock ./

# Instala dependências sem rodar scripts (ainda não temos artisan)
RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader --no-scripts

# Agora copia o restante do projeto
COPY . .

# Otimiza autoload e roda package discover agora que artisan existe
RUN composer dump-autoload --optimize
RUN php artisan package:discover

# ============================
# 2) Runtime Stage
# ============================
FROM php:8.2-fpm

WORKDIR /var/www/html

# Instala extensões PHP necessárias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    unzip \
    git \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd \
    && rm -rf /var/lib/apt/lists/*

# Copia o projeto do build
COPY --from=build /app /var/www/html

# Copia o entrypoint
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Define permissões
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Expõe a porta do PHP-FPM
EXPOSE 9000

# Usa entrypoint para rodar migrations
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]
