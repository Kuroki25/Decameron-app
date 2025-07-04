FROM php:8.2-fpm AS builder

# Instala dependencias de sistema para extensiones
RUN apt-get update && apt-get install -y \
    libpq-dev libonig-dev zip unzip \
  && docker-php-ext-install pdo_pgsql mbstring

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copia sólo composer.json y composer.lock para aprovechar caching
COPY composer.json composer.lock ./

# Instala dependencias sin ejecutar scripts
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Ahora sí copia todo el código, incluyendo artisan
COPY . .

# Ejecuta scripts pendientes y descubrimiento de paquetes
RUN composer run-script post-autoload-dump \
 && php artisan package:discover --ansi \
 && php artisan key:generate

# Etapa final
FROM php:8.2-fpm-alpine

RUN apk add --no-cache libpq

COPY --from=builder /var/www/html /var/www/html

WORKDIR /var/www/html

EXPOSE 80

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
