#!/bin/sh
set -e

# Run database migrations automatically on startup
echo "Running database migrations..."
php artisan migrate --force --no-interaction

# Execute CMD
exec "$@"
