FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    libcurl4-openssl-dev \
    pkg-config \
    && docker-php-ext-install pdo mbstring zip exif pcntl gd curl

# Install MongoDB extension (compatible with mongodb/mongodb 1.21)
RUN pecl install mongodb-1.21.4 \
    && docker-php-ext-enable mongodb

# Configure Git safe directory to avoid composer warnings
RUN git config --global --add safe.directory /var/www/html

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . /var/www/html

RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

RUN php artisan key:generate --ansi

CMD ["php-fpm"]