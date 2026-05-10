#!/bin/sh
set -e

if [ "$1" = 'frankenphp' ]; then
    if [ -z "$APP_KEY" ]; then
        export APP_KEY=$(php artisan key:generate --show)
        echo "First-time app initialization... Need to set up encryption key, put this line into .env file and restart app:\nAPP_KEY=$APP_KEY"
        sleep 30;
        exit;
    fi

  mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs storage/app/private

  touch storage/database.sqlite

  echo "Waiting for database to be ready..."
  ATTEMPTS_LEFT_TO_REACH_DATABASE=60

  until [ $ATTEMPTS_LEFT_TO_REACH_DATABASE -eq 0 ] || DATABASE_ERROR=$(php artisan db:monitor 2>&1); do
      if [ $? -eq 255 ]; then
          # If the Doctrine command exits with 255, an unrecoverable error occurred
          ATTEMPTS_LEFT_TO_REACH_DATABASE=0
          break
      fi
      sleep 1
      ATTEMPTS_LEFT_TO_REACH_DATABASE=$((ATTEMPTS_LEFT_TO_REACH_DATABASE - 1))
      echo "Still waiting for database to be ready... Or maybe the database is not reachable. $ATTEMPTS_LEFT_TO_REACH_DATABASE attempts left."
  done

  if [ $ATTEMPTS_LEFT_TO_REACH_DATABASE -eq 0 ]; then
      echo "The database is not up or not reachable:"
      echo "$DATABASE_ERROR"
      exit 1
  else
      echo "The database is now ready and reachable"
  fi

  php artisan migrate --force --no-interaction

  php artisan optimize
fi

exec docker-php-entrypoint "$@"
