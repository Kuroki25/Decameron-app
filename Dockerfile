# Etapa de build
FROM php:8.2-fpm AS builder

# Instala extensiones necesarias
RUN apt-get update && apt-get install -y \
    libpq-dev zip unzip \
  && docker-php-ext-install pdo_pgsql mbstring

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Sólo dependencias PHP
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Copia el resto del código
COPY . .

# Genera la clave y ejecuta migraciones (opcional aquí o en comando de inicio)
RUN php artisan key:generate

# Etapa final
FROM php:8.2-fpm-alpine

RUN apk add --no-cache libpq

COPY --from=builder /var/www/html /var/www/html

WORKDIR /var/www/html

EXPOSE 80

# Usa el servidor integrado para simplificar despliegue
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
