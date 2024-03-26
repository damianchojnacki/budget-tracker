#!/bin/bash

docker info > /dev/null 2>&1

# Ensure that Docker is running...
if [ $? -ne 0 ]; then
    echo "Docker is not running."

    exit 1
fi

if [ ! -f .env ]; then
    cp .env.example .env

    echo "Created default .env configuration."
fi

docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd)":/var/www/html \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs --no-cache

docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd)":/var/www/html \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    php artisan key:generate

CYAN='\033[0;36m'
LIGHT_CYAN='\033[1;36m'
WHITE='\033[1;37m'
NC='\033[0m'

echo ""

if sudo -n true 2>/dev/null; then
    sudo chmod 775 -R storage
    sudo chmod 775 -R bootstrap
else
    echo -e "${WHITE}Please provide your password so we can make some final adjustments to your application's permissions.${NC}"
    echo ""
    sudo chmod 775 -R storage
    sudo chmod 775 -R bootstrap
    echo ""
    echo -e "${WHITE}Thank you!"
fi

./vendor/bin/sail up -d

./vendor/bin/sail artisan storage:link

./vendor/bin/sail artisan migrate --seed

./vendor/bin/sail --help

echo "Please add alias to .bashrc or .profile to easily run sail:"
echo "alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'"
