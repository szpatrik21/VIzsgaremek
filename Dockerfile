FROM php:8.2-cli

WORKDIR /var/www

# rendszer csomagok
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    zip

# php extensionök
RUN docker-php-ext-install pdo pdo_mysql zip

# composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# projekt bemásolása
COPY . .

# composer install
RUN composer install --no-dev --optimize-autoloader

# port
EXPOSE 10000

CMD php -S 0.0.0.0:$PORT -t public