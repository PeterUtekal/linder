FROM composer:2.6 as composer-build
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    postgresql-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libzip-dev \
    $PHPIZE_DEPS \
    zip \
    unzip \
    git \
    curl \
    nginx \
    supervisor \
    nodejs \
    npm

RUN docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install pdo pdo_pgsql gd zip opcache pcntl

RUN pecl install redis && docker-php-ext-enable redis

COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini

WORKDIR /var/www/html

COPY . .

COPY --from=composer-build /app/vendor ./vendor
COPY --from=composer-build /usr/bin/composer /usr/bin/composer
RUN ln -s /usr/bin/composer /usr/local/bin/composer

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

RUN mkdir -p storage/app/public storage/framework/cache storage/framework/sessions storage/framework/views storage/logs \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 9000

HEALTHCHECK --interval=30s --timeout=3s --retries=3 \
    CMD php artisan tinker --execute="echo 1;" || exit 1

CMD ["php-fpm"] 