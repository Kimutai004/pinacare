#!/bin/sh
set -e

php -r '$key = getenv("APP_KEY") ?: ""; $key = str_starts_with($key, "base64:") ? base64_decode(substr($key, 7), true) : $key; if (strlen($key) !== 32) { fwrite(STDERR, "APP_KEY must be a valid Laravel 32-byte key. Generate one with: php artisan key:generate --show\n"); exit(1); }'

php artisan storage:link || true
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

exec apache2-foreground