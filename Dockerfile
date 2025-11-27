# Use official PHP image with required extensions
FROM php:8.2-cli

# Install system packages
RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    libssl-dev \
    pkg-config \
    && rm -rf /var/lib/apt/lists/*

# Install MongoDB PHP extension
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

# Install Laravel required extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Laravel optimization (optional but good)
RUN php artisan config:cache || true
RUN php artisan route:cache || true
RUN php artisan view:cache || true

# Expose port (Railway assigns dynamically)
EXPOSE 8080

# Start server
CMD php artisan serve --host=0.0.0.0 --port=${PORT}
