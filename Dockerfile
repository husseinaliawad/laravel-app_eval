FROM php:8.2-cli

WORKDIR /var/www/html

# 1) System deps (include sqlite dev) + build PHP extensions with low parallelism
RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
        git \
        unzip \
        libzip-dev \
        libonig-dev \
        libxml2-dev \
        libsqlite3-dev \
    ; \
    \
    # Reduce RAM pressure during build (common Render issue)
    export MAKEFLAGS="-j1"; \
    docker-php-ext-install -j1 \
        bcmath \
        mbstring \
        pdo_mysql \
        pdo_sqlite \
        xml \
        zip \
    ; \
    \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/*

# 2) Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 3) App env
ENV APP_ENV=production \
    APP_DEBUG=false \
    COMPOSER_ALLOW_SUPERUSER=1

# 4) Copy only composer files first (better caching), then install deps
COPY composer.json composer.lock ./

RUN set -eux; \
    composer install \
      --no-dev \
      --no-interaction \
      --prefer-dist \
      --optimize-autoloader \
      --no-progress

# 5) Copy the rest of the app
COPY . .

# 6) Laravel folders perms (Render runs container user; we switch later)
RUN set -eux; \
    mkdir -p storage bootstrap/cache; \
    chown -R www-data:www-data storage bootstrap/cache; \
    chmod -R 775 storage bootstrap/cache

# Optional: generate key at runtime instead (recommended) — do NOT bake secrets in image
# RUN php artisan key:generate --force

EXPOSE 10000

USER www-data

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
