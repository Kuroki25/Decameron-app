FROM php:8.2-fpm AS builder

# 1) Dependencias de SO para pdo_pgsql y mbstring
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libonig-dev \
    zip unzip \
  && docker-php-ext-install pdo_pgsql mbstring

# 2) Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 3) Copiar composer.json y lock para usar cache de layers
COPY composer.json composer.lock ./

# 4) Instalar dependencias sin scripts (aún no está artisan)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# 5) Copiar todo el código, incluyendo artisan y el .env.example
COPY . .

# 6) Asegurar que exista un .env para los comandos artisan
RUN cp .env.example .env

# 7) Ejecutar los scripts pendientes, descubrir paquetes y generar KEY
RUN composer run-script post-autoload-dump \
 && php artisan package:discover --ansi \
 && php artisan key:generate

# Etapa final: imagen ligera para correr
FROM php:8.2-fpm-alpine

RUN apk add --no-cache libpq

COPY --from=builder /var/www/html /var/www/html

WORKDIR /var/www/html

EXPOSE 80

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
