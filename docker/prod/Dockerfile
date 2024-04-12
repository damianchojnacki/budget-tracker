ARG PHP_EXTENSIONS="bcmath exif gd imap intl pdo_mysql sockets uuid redis imagick gd"

FROM thecodingmachine/php:8.1-v4-fpm

ENV PHP_EXTENSIONS="bcmath exif gd imap intl pdo_mysql sockets uuid redis imagick gd"

ENV TEMPLATE_PHP_INI=production
ENV PHP_INI_MEMORY_LIMIT=2g
ENV PHP_INI_UPLOAD_MAX_FILESIZE=10MB

RUN sudo apt-get update -y && \
    sudo apt-get install -y locales mysql-client && \
    sudo locale-gen pl_PL.utf8 && \
    echo "LANG=pl_PL.utf8" >> ~/.bashrc && \
    sudo apt-get clean -y && \
    sudo apt-get autoremove -y

COPY --chown=docker:docker . /var/www/html

RUN composer install --no-dev --no-interaction --optimize-autoloader
RUN php artisan storage:link

EXPOSE 9000
