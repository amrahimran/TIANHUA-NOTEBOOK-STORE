# =========================
# Stage 1: Build frontend
# =========================
FROM node:20 AS node-builder

WORKDIR /app

# Copy Node package files
COPY package*.json ./

# Install Node dependencies
RUN npm install

# Copy the ENTIRE project for Vite (so vite.config.js and resources exist)
COPY . .

# Build Vite assets for Laravel
RUN npm run build

# =========================
# Stage 2: PHP / Laravel
# =========================
FROM php:8.2-fpm

WORKDIR /var/www

# Install system dependencies & PHP extensions
RUN apt-get update && apt-get install -y \
    git zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev libcurl4-openssl-dev pkg-config libssl-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy Laravel app
COPY . .

# Copy built Vite assets from Node stage
COPY --from=node-builder /app/public/build ./public/build

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# Set permissions for storage and cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Clear and cache Laravel configs
RUN php artisan config:clear && php artisan cache:clear && php artisan route:clear && php artisan view:clear && php artisan config:cache

# Expose port (Railway will map $PORT)
EXPOSE 9000

# Start PHP-FPM (production-ready)
CMD ["php-fpm"]
