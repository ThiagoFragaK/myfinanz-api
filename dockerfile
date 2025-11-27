FROM php:8.3.3-apache

RUN apt-get update

RUN apt-get install --yes --force-yes cron g++ gettext libicu-dev openssl libc-client-dev libkrb5-dev libgd-dev libmcrypt-dev bzip2 libbz2-dev libtidy-dev libcurl4-openssl-dev libz-dev libmemcached-dev libxslt-dev

RUN apt-get update && apt-get install -y \
    cron g++ gettext libicu-dev openssl libc-client-dev libkrb5-dev libgd-dev libmcrypt-dev bzip2 libbz2-dev \
    libtidy-dev libcurl4-openssl-dev libz-dev libmemcached-dev libxslt-dev \
    libonig-dev libpq-dev libxml2-dev libpng-dev libzip-dev libfreetype6-dev \
    libjpeg62-turbo-dev libmagickwand-dev libgmp-dev zip npm

RUN a2enmod rewrite

RUN docker-php-ext-install \
    pcntl \
    zip \
    pdo_pgsql \
    pgsql \
    intl \
    gd \
    gmp \
    pdo \
    bcmath

RUN docker-php-ext-configure gd --with-freetype=/usr --with-jpeg=/usr

RUN docker-php-ext-install gd

RUN a2enmod headers

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./ /var/www/html/

COPY .env.production /var/www/html/.env

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN echo "memory_limit=4096M" > /usr/local/etc/php/conf.d/php.ini
RUN echo "upload_max_filesize=50M" >> /usr/local/etc/php/conf.d/php.ini
RUN echo "max_input_time=512" >> /usr/local/etc/php/conf.d/php.ini
RUN echo "max_input_vars=5000" >> /usr/local/etc/php/conf.d/php.ini
RUN echo "max_execution_time=300" >> /usr/local/etc/php/conf.d/php.ini
RUN echo "post_max_size=100M" >> /usr/local/etc/php/conf.d/php.ini
RUN echo "display_errors=On" >> /usr/local/etc/php/conf.d/php.ini
RUN echo "log_errors=On" >> /usr/local/etc/php/conf.d/php.ini
RUN echo "zend_extension=opcache" >> /usr/local/etc/php/conf.d/php.ini
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/php.ini
RUN echo "opcache.memory_consumption=256" >> /usr/local/etc/php/conf.d/php.ini
RUN echo "opcache.interned_strings_buffer=8" >> /usr/local/etc/php/conf.d/php.ini
RUN echo "opcache.max_accelerated_files=10000" >> /usr/local/etc/php/conf.d/php.ini
RUN echo "opcache.revalidate_freq=60" >> /usr/local/etc/php/conf.d/php.ini
RUN echo "opcache.save_comments=1" >> /usr/local/etc/php/conf.d/php.ini
RUN echo "opcache.enable_cli=1" >> /usr/local/etc/php/conf.d/php.ini

RUN composer install --no-interaction --optimize-autoloader --no-dev

RUN npm install

RUN npm run build

RUN chmod -R 777 /var/www/html/storage

RUN php artisan storage:link

RUN php artisan optimize