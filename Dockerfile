# ---------- Stage 1: Build frontend (Vite) ----------
FROM node:20-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json* pnpm-lock.yaml* yarn.lock* ./

# استخدم npm افتراضياً (لو عندك yarn/pnpm خبرني)
RUN npm install

COPY . .

RUN npm run build


# ---------- Stage 2: PHP + Composer ----------
FROM php:8.2-cli

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libzip-dev \
        libonig-dev \
        libxml2-dev \
    && docker-php-ext-install \
        bcmath \
        mbstring \
        pdo_mysql \
        pdo_sqlite \
        xml \
        zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# انسخ ملفات PHP أولاً ثم composer install
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-progress

# انسخ باقي المشروع
COPY . .

# انسخ build الناتج من Vite
COPY --from=frontend /app/public/build /var/www/html/public/build

ENV APP_ENV=production \
    APP_DEBUG=false

RUN php artisan config:cache || true \
    && php artisan route:cache || true \
    && php artisan view:cache || true \
    && mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 10000

USER www-data

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
