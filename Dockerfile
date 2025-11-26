# Stage 1: Build
FROM node:20 AS node-builder

WORKDIR /app

# Copy package.json and package-lock.json
COPY package*.json ./

# Install Node dependencies
RUN npm install

# Copy Laravel frontend assets
COPY resources/js resources/js
COPY resources/css resources/css

# Build Vite assets
RUN npm run build

# Stage 2: PHP
FROM php:8.2-fpm

WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev libcurl4-openssl-dev pkg-config libssl-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy Laravel app
COPY . .

# Copy built Vite assets from node-builder
COPY --from=node-builder /app/dist public/build

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Clear and cache config
RUN php artisan config:clear && php artisan cache:clear && php artisan route:clear && php artisan view:clear && php artisan config:cache

# Expose port (Railway uses dynamic $PORT)
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
