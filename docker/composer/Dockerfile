FROM composer/composer:alpine

RUN apk --update add \
    postgresql-dev

RUN docker-php-ext-install \
    pdo \
    pdo_pgsql

WORKDIR /usr/share/nginx/granty
