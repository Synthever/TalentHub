#!/bin/sh

# Exit on error
set -e

echo "Starting TalentHub application setup..."

# Wait for database to be ready
until php artisan db:show --no-ansi 2>/dev/null; do
    echo "Waiting for database connection..."
    sleep 2
done

echo "Database is ready!"

# Run migrations
php artisan migrate --force --no-interaction

# Clear and cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Application setup complete!"

# Start PHP-FPM
exec php-fpm
