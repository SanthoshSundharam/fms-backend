#!/bin/bash

set -e

echo "Starting Laravel application..."

php artisan config:cache
php artisan route:cache
php artisan view:cache

php artisan migrate --force

php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
