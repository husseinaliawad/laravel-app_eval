FROM php:8.2-cli

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git unzip \
        libzip-dev libonig-dev libxml2-dev \
        libsqlite3-dev sqlite3 \
    && docker-php-ext-install \
        bcmath mbstring pdo_mysql pdo_sqlite xml zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# انسخ كل المشروع أولاً (حتى يكون artisan موجود)
COPY . .

ENV APP_ENV=production \
    APP_DEBUG=false

# بعدين شغّل composer
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-progress

RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 10000
USER www-data
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
