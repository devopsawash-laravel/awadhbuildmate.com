#!/bin/sh

echo "Waiting for database..."

sleep 15

echo "Running migrations..."

php artisan migrate --force

echo "Running seeders..."

php artisan db:seed --force

echo "Starting Laravel server..."

php artisan serve --host=0.0.0.0 --port=$PORT