# #!/bin/sh

# echo "Waiting for PostgreSQL..."

# sleep 20

# echo "Running migrations..."

# php artisan migrate --force

# echo "Running seeders..."

# php artisan db:seed --force

# echo "Clearing cache..."

# php artisan optimize:clear

# echo "Starting Laravel..."

# php artisan serve --host=0.0.0.0 --port=$PORT

# Updated wihtout redundant seeders

echo "Waiting for PostgreSQL..."

sleep 20

echo "Running migrations..."

php artisan migrate --force

echo "Clearing cache..."

php artisan optimize:clear

echo "Starting Laravel..."

php artisan serve --host=0.0.0.0 --port=$PORT