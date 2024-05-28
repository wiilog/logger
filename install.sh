#!/bin/sh

set -e

execute_query() {
    mysql "$2" -h "$DATABASE_HOST" -P "$DATABASE_PORT" -u "$DATABASE_USER" -p"$DATABASE_PASSWORD" -sse "$1"
}

prepare_project() {
    echo ">>>>>> composer install"
    composer install \
        --no-dev \
        --optimize-autoloader \
        --classmap-authoritative \
        --no-ansi

    echo ">>>>>> yarn install"
    yarn install
}

install_symfony() {
    echo ">>>>>> install_symfony"

    echo ">>>>>> php bin/console doctrine:schema:update --force --dump-sql"
    php bin/console doctrine:schema:update --force --dump-sql

    echo ">>>>>> php bin/console cache:clear"
    php bin/console cache:clear

    echo ">>>>>> php bin/console cache:warmup"
    php bin/console cache:warmup
}

build_yarn() {
    echo ">>>>>> yarn build"
    yarn build
}

cd /project

prepare_project
install_symfony

echo "Current date: $(date)"
