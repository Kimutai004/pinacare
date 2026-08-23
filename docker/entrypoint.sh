#!/bin/sh
set -e

php -r '$key = getenv("APP_KEY") ?: ""; $key = str_starts_with($key, "base64:") ? base64_decode(substr($key, 7), true) : $key; if (strlen($key) !== 32) { fwrite(STDERR, "APP_KEY must be a valid Laravel 32-byte key. Generate one with: php artisan key:generate --show\n"); exit(1); }'

echo "Starting Laravel application..."
php artisan storage:link || true
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "Running migrations..."
if ! php artisan migrate --force --verbose; then
    echo "ERROR: Migrations failed!"
    exit 1
fi
echo "Migrations completed. Seeding database..."
if ! php artisan db:seed --force --verbose; then
    echo "WARNING: Database seeding failed, but continuing..."
fi
echo "Database seeded. Application ready!"

exec apache2-foreground