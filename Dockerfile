# ┌───────────────────────────────────────────────────────────────────────────────
# │ Etapa 1: builder (Debian-based)
# └───────────────────────────────────────────────────────────────────────────────
FROM php:8.2-fpm AS builder

# 1) Instala dependencias de SO + compila pdo_pgsql y mbstring
RUN apt-get update \
 && apt-get install -y libpq-dev libonig-dev zip unzip \
 && docker-php-ext-install pdo_pgsql mbstring \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2) Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 3) Copia los archivos de Composer y corre install (sin scripts todavía)
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# 4) Copia el resto de tu código y genera la key
COPY . .
RUN cp .env.example .env \
 && composer run-script post-autoload-dump \
 && php artisan package:discover --ansi \
 && php artisan key:generate

# ┌───────────────────────────────────────────────────────────────────────────────
# │ Etapa 2: runtime (Alpine-based)
# └───────────────────────────────────────────────────────────────────────────────
FROM php:8.2-fpm-alpine

# 1) Instala cliente de Postgres + oniguruma + herramientas de compilación
#    para que docker-php-ext-install funcione en Alpine
RUN apk add --no-cache \
      libpq-dev \
      oniguruma-dev \
      build-base autoconf \
  && docker-php-ext-install pdo_pgsql mbstring \
  && apk del build-base autoconf

WORKDIR /var/www/html

# 2) Copia todo lo que dejó el builder (código, vendor, artisan, etc)
COPY --from=builder /var/www/html /var/www/html

EXPOSE 80

# 3) Limpia configuração cacheada y arranca el servidor
CMD ["sh", "-c", "\
    php artisan config:clear && \
    php artisan cache:clear && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=80 \
"]
