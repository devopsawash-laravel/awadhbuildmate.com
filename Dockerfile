FROM php:8.2-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libpq-dev

# Install PostgreSQL driver
RUN docker-php-ext-install pdo pdo_pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set app directory
WORKDIR /app

# Copy project
COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Clear Laravel cache
RUN php artisan optimize:clear || true

# Create storage link
RUN php artisan storage:link || true

# Expose Render port
EXPOSE 10000

# START CONTAINER
CMD php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=$PORT