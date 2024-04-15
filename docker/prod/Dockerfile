ARG PHP_EXTENSIONS="bcmath gd imap intl pdo_mysql uuid igbinary redis sqlite3 pdo_sqlite"

FROM thecodingmachine/php:8.3-v4-slim-fpm

ARG PHP_EXTENSIONS="bcmath gd imap intl pdo_mysql uuid igbinary redis sqlite3 pdo_sqlite"

ENV TEMPLATE_PHP_INI=production
ENV PHP_INI_MEMORY_LIMIT=2g
ENV PHP_INI_UPLOAD_MAX_FILESIZE=10M

RUN sudo apt-get update -y && \
    sudo apt-get install -y locales mysql-client && \
    sudo locale-gen pl_PL.utf8 && \
    echo "LANG=pl_PL.utf8" >> ~/.bashrc && \
    sudo apt-get clean -y && \
    sudo apt-get autoremove -y

COPY --chown=docker:docker . /var/www/html

RUN composer install --no-dev --no-interaction --optimize-autoloader && \
    php artisan storage:link && \
    php artisan optimize:clear && \
    sudo cp docker/prod/entrypoint.sh /entrypoint && \
    sudo chmod +x /entrypoint

EXPOSE 9000

ENTRYPOINT ["/entrypoint"]
