# Stage 1: Build the vendor directory
FROM composer:2 AS vendor
WORKDIR /app
# Only copy composer.json to build fresh
COPY composer.json ./
# Remove any existing lock file just in case it's incompatible
RUN rm -f composer.lock
# Install dependencies bypassing platform checks
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

# Stage 2: Final PHP image
FROM php:8.4-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    oniguruma-dev \
    libzip-dev \
    linux-headers \
    icu-dev

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql bcmath gd mbstring zip intl

WORKDIR /var/www/html

# Copy application files
COPY . .

# Copy vendor from vendor stage
COPY --from=vendor /app/vendor ./vendor

# Copy composer binary and regenerate autoloader with all source files present
COPY --from=vendor /usr/bin/composer /usr/local/bin/composer
RUN composer dump-autoload --optimize --no-scripts --no-interaction

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
