FROM php:8.2-fpm-alpine AS builder
ARG COMPOSER_HOME="/composer"
ENV COMPOSER_HOME=${COMPOSER_HOME} COMPOSER_MEMORY_LIMIT=-1 APP_ENV=production
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS git unzip curl oniguruma-dev libzip-dev postgresql-dev tzdata \
  && pecl install apcu \
  && docker-php-ext-enable apcu \
  && docker-php-ext-install pdo_pgsql mbstring zip \
  && docker-php-source delete \
  && apk del .build-deps
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /app
COPY composer.json composer.lock ./
RUN --mount=type=cache,id=composer-cache,target=/root/.cache/composer \
    composer install --no-dev --no-scripts --prefer-dist \
      --optimize-autoloader --classmap-authoritative
COPY . .
RUN composer run-script post-install-cmd \
  && php artisan clear-compiled \
  && php artisan optimize \
  && addgroup -g 1000 appuser \
  && adduser -u 1000 -G appuser -s /bin/sh -D appuser \
  && mkdir -p storage bootstrap/cache \
  && chown -R appuser:appuser storage bootstrap/cache

FROM builder AS tests
USER appuser
RUN --mount=type=cache,id=composer-cache,target=/root/.cache/composer \
    vendor/bin/phpunit --stop-on-failure

FROM php:8.2-fpm-alpine AS production
LABEL maintainer="tu-email@dominio.com"
RUN apk add --no-cache libpq oniguruma libzip tzdata
COPY --from=builder /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d
COPY --from=builder /app /app
WORKDIR /app
USER appuser
EXPOSE 9000
HEALTHCHECK --interval=30s --timeout=5s --start-period=5s \
  CMD php artisan route:cache || exit 1
CMD ["php-fpm"]
