#!/bin/bash
set -e

# Wait for database to be ready
echo "Waiting for database connection..."
until php artisan db:show --no-ansi > /dev/null 2>&1; do
    sleep 2
done

echo "Database ready. Running migrations and seeders..."
php artisan migrate --seed --force

echo "Starting Apache..."
exec apache2-foreground
