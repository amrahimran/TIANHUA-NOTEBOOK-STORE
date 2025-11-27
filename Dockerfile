# ---- Build Stage ----
FROM php:8.2-fpm AS build

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl unzip libpng-dev libonig-dev libxml2-dev libzip-dev zip libicu-dev \
    && docker-php-ext-install pdo pdo_mysql zip intl

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy app source
WORKDIR /var/www/html
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Build Laravel caches
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache


# ---- Production Stage ----
FROM php:8.2-fpm

WORKDIR /var/www/html

# Install required PHP extensions again
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev libzip-dev libicu-dev \
    && docker-php-ext-install pdo pdo_mysql zip intl

# Copy built app
COPY --from=build /var/www/html /var/www/html

# Expose port Railway uses
EXPOSE 8080

# Start command (Railway sets PORT=8080)
CMD php artisan serve --host=0.0.0.0 --port=8080
