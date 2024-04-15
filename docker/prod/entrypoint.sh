#!/usr/bin/env bash

touch /var/www/html/storage/database.sqlite

php /var/www/html/artisan migrate --force

php /var/www/html/artisan config:cache --no-ansi -q
php /var/www/html/artisan route:cache --no-ansi -q
php /var/www/html/artisan view:cache --no-ansi -q
php /var/www/html/artisan event:cache --no-ansi -q

exec "$@"
