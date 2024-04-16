#!/usr/bin/env bash

touch /var/www/html/storage/database.sqlite

php /var/www/html/artisan migrate --force

mkdir -p /var/www/html/storage/logs /var/www/html/storage/framework/cache /var/www/html/storage/framework/views /var/www/html/storage/framework/sessions

php /var/www/html/artisan config:cache --no-ansi -q
php /var/www/html/artisan route:cache --no-ansi -q
php /var/www/html/artisan view:cache --no-ansi -q
php /var/www/html/artisan event:cache --no-ansi -q

sudo cp -r /var/www/html/* /code

exec "$@"
