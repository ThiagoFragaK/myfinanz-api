FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libonig-dev \
    curl \
    libpq-dev \
    && docker-php-ext-install mbstring pdo pdo_pgsql

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose Render port
EXPOSE 10000

# Copy deploy script
COPY deploy.sh /deploy.sh
RUN chmod +x /deploy.sh

# Start deploy script
CMD ["/deploy.sh"]
