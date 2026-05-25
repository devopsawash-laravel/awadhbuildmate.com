# FROM php:8.2-cli

# RUN apt-get update && apt-get install -y \
#     git \
#     unzip \
#     zip \
#     curl \
#     sqlite3 \
#     libsqlite3-dev \
#     libzip-dev \
#     && docker-php-ext-install pdo pdo_sqlite zip

# COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# WORKDIR /var/www

# COPY . .

# RUN composer install --no-dev --optimize-autoloader

# RUN chmod -R 777 storage bootstrap/cache

# RUN mkdir -p database

# RUN touch database/database.sqlite

# EXPOSE 10000

# CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port

FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    sqlite3 \
    libsqlite3-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_sqlite zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN chmod -R 777 storage bootstrap/cache

RUN mkdir -p database

RUN touch database/database.sqlite

EXPOSE 10000

# CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port
# CMD php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=10000