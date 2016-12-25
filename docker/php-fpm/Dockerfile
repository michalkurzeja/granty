FROM php:7.1-fpm-alpine

RUN apk --update add \
    acl \
    icu-dev \
    postgresql-dev

RUN docker-php-ext-install \
    opcache \
    intl \
    pdo \
    pdo_pgsql

ADD template/set-acl.sh /set-acl.sh
