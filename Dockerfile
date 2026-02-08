FROM node:20-alpine AS assets

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY resources ./resources
COPY public ./public
COPY vite.config.js postcss.config.js tailwind.config.js ./

RUN npm run build

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

ENV APP_ENV=production \
    APP_DEBUG=false

# 1) copy composer files
COPY composer.json composer.lock ./

# 2) install vendors WITHOUT scripts (artisan not available yet)
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-progress --no-scripts

# 3) copy the full app (now artisan exists)
COPY . .

# 3.1) copy Vite build output
COPY --from=assets /app/public/build /var/www/html/public/build

# 4) run scripts after artisan exists
RUN php artisan package:discover --ansi

RUN mkdir -p storage bootstrap/cache \
  && chown -R www-data:www-data storage bootstrap/cache \
  && chmod -R 775 storage bootstrap/cache

EXPOSE 10000
USER www-data

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
