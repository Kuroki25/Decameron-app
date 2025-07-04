# --- Etapa Base ---
FROM php:8.2-fpm-alpine AS base
RUN apk add --no-cache libpq oniguruma libzip tzdata
RUN docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl \
    && pecl install apcu \
    && docker-php-ext-enable apcu opcache
COPY ./docker/php/conf.d/ /usr/local/etc/php/conf.d/

# --- Etapa de Dependencias ---
FROM base AS composer_deps
RUN apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS \
    git \
    unzip \
    curl \
    postgresql-dev
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --prefer-dist --no-scripts --no-autoloader --no-interaction
RUN apk del .build-deps

# --- Etapa de Construcción de la App ---
FROM composer_deps AS app_builder
WORKDIR /app
COPY . .
RUN composer dump-autoload --optimize --classmap-authoritative \
    && composer run-script post-install-cmd --no-dev \
    && php artisan optimize:clear \
    && php artisan view:cache \
    && php artisan config:cache
RUN php -d opcache.enable_cli=1 -d opcache.jit_buffer_size=50M artisan-opcache-preload:generate

# --- Etapa de Pruebas ---
FROM app_builder AS tests
WORKDIR /app
RUN vendor/bin/phpunit --stop-on-failure

# --- Etapa de Producción Final ---
FROM base AS production
LABEL maintainer="darosero89@gmail.com"
RUN addgroup -g 1000 laravel && \
    adduser -u 1000 -G laravel -s /bin/sh -D laravel
WORKDIR /app
COPY --from=composer_deps /usr/bin/composer /usr/bin/composer
COPY --from=app_builder /app .
COPY --from=app_builder /app/storage/opcache-preload.php /app/storage/opcache-preload.php
RUN composer install --no-dev --no-autoloader --no-scripts --no-interaction
RUN php artisan route:cache \
    && php artisan event:cache
RUN chown -R laravel:laravel storage bootstrap/cache
USER laravel
EXPOSE 9000
CMD ["php-fpm"]
