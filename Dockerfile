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

# 4) Copia el resto de tu código
COPY . .

# ┌───────────────────────────────────────────────────────────────────────────────
# │ Etapa 2: runtime (Alpine-based)
# └───────────────────────────────────────────────────────────────────────────────
FROM php:8.2-fpm-alpine

ENV CACHE_DRIVER=file \
    SESSION_DRIVER=cookie \
    QUEUE_CONNECTION=database

# Instala pdo_pgsql y mbstring en Alpine
RUN apk add --no-cache \
      libpq-dev \
      oniguruma-dev \
      build-base autoconf \
  && docker-php-ext-install pdo_pgsql mbstring \
  && apk del build-base autoconf

WORKDIR /var/www/html

# Trae todo lo generado por el builder
COPY --from=builder /var/www/html /var/www/html

EXPOSE 80

ENTRYPOINT ["sh", "-c"]

# Aquí añadimos el --seed al migrate para que ejecute seeders automáticos
CMD ["php artisan config:clear && \
     php artisan cache:clear && \
     php artisan migrate --force --seed && \
     php artisan serve --host=0.0.0.0 --port=80"]
