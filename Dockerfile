FROM php:8.2-fpm-alpine AS builder
RUN apk add --no-cache \
    $PHPIZE_DEPS \
    build-base \
    postgresql-dev \
    libzip-dev \
    oniguruma-dev \
    git \
    curl \
    unzip
RUN docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl \
    && pecl install apcu \
    && docker-php-ext-enable apcu opcache
COPY ./docker/php/conf.d/ /usr/local/etc/php/conf.d/
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-scripts --prefer-dist
COPY . .
RUN composer dump-autoload --optimize --classmap-authoritative \
    && php artisan optimize:clear \
    && php artisan view:cache \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan event:cache \
    && php -d opcache.enable_cli=1 -d opcache.jit_buffer_size=50M artisan-opcache-preload:generate

FROM php:8.2-fpm-alpine AS production
RUN apk add --no-cache libpq oniguruma libzip tzdata
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/
COPY --from=builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
RUN addgroup -g 1000 laravel && \
    adduser -u 1000 -G laravel -s /bin/sh -D laravel
WORKDIR /app
COPY --from=builder /app .
RUN chown -R laravel:laravel storage bootstrap/cache
USER laravel
EXPOSE 9000
CMD ["php-fpm"]
