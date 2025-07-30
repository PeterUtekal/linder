# syntax=docker/dockerfile:1

#############################
# 1. Build PHP dependencies #
#############################
FROM composer:2.6 AS composer-deps
WORKDIR /app

# Copy composer manifests from the Laravel codebase
COPY airdrop-viral-app/backend/composer.json ./

# Install production dependencies (no dev) optimised for autoloading
RUN composer install --no-dev --prefer-dist --no-scripts --no-interaction --optimize-autoloader

#######################
# 2. Build application #
#######################
FROM php:8.2-apache AS app

# Install system packages required for common Laravel features and MongoDB PHP driver
RUN apt-get update -y \
    && apt-get install -y --no-install-recommends \
        libpng-dev libjpeg-dev libonig-dev libzip-dev git unzip \
        && pecl install mongodb \
        && docker-php-ext-enable mongodb \
        # Enable required PHP extensions
        && docker-php-ext-install pdo zip mbstring \
        && rm -rf /var/lib/apt/lists/*

# Configure Apache to serve the Laravel public directory
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}/../!g' /etc/apache2/apache2.conf

WORKDIR /var/www/html

# Copy application source
COPY airdrop-viral-app/backend/ ./
# Copy installed vendor directory from build stage
COPY --from=composer-deps /app/vendor ./vendor

# Ensure correct permissions for storage & cache
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80

# Default run command
CMD ["apache2-foreground"]