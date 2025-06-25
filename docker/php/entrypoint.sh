#!/usr/bin/env bash
set -e

if [ ! -f /var/www/vendor/autoload.php ]; then
  echo "⏳ First run: installing Composer dependencies..."
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi

echo "🔄 Running database migrations..."
php artisan migrate --force

exec "$@"
