# ---------- 1) Frontend build (Vite) ----------
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build


# ---------- 2) PHP deps (Composer) ----------
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader
COPY . .


# ---------- 3) Runtime (PHP) ----------
FROM php:8.2-cli

WORKDIR /var/www

# System deps
RUN apt-get update && apt-get install -y \
    git unzip curl zip libzip-dev \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libonig-dev libicu-dev \
    && rm -rf /var/lib/apt/lists/*

# PHP extensions (Laravel common)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
      bcmath \
      mbstring \
      intl \
      zip \
      gd \
      pdo \
      pdo_mysql \
      pdo_pgsql \
      opcache

# Copy app source
COPY . .

# Copy vendor from composer stage
COPY --from=vendor /app/vendor /var/www/vendor

# Copy built assets from node stage (Vite -> public/build)
COPY --from=frontend /app/public/build /var/www/public/build

# Permissions for Laravel
RUN chmod -R 775 storage bootstrap/cache || true

# Render provides $PORT
CMD php -S 0.0.0.0:${PORT} -t public