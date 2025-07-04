FROM php:8.2-fpm-alpine AS base
RUN apk add --no-cache libpq oniguruma libzip tzdata
RUN docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl \
    && pecl install apcu \
    && docker-php-ext-enable apcu opcache
COPY ./docker/php/conf.d/ /usr/local/etc/php/conf.d/

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
RUN --mount=type=cache,id=composer,target=/root/.cache/composer \
    composer install --prefer-dist --no-scripts --no-autoloader --no-interaction
RUN apk del .build-deps

FROM composer_deps AS app_builder
WORKDIR /app
COPY . .
RUN composer dump-autoload --optimize --classmap-authoritative \
    && composer run-script post-install-cmd --no-dev \
    && php artisan optimize:clear

FROM app_builder AS tests
WORKDIR /app
RUN vendor/bin/phpunit --stop-on-failure

FROM base AS production
LABEL maintainer="darosero89@gmail.com"
RUN addgroup -g 1000 laravel && \
    adduser -u 1000 -G laravel -s /bin/sh -D laravel
WORKDIR /app
COPY --from=composer_deps /usr/bin/composer /usr/bin/composer
COPY --from=app_builder /app .
RUN composer install --no-dev --no-autoloader --no-scripts --no-interaction
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan event:cache
RUN chown -R laravel:laravel storage bootstrap/cache
USER laravel
EXPOSE 9000
CMD ["php-fpm"]
