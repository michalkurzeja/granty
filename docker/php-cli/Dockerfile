FROM php:7.1-alpine

RUN apk --update add \
    icu-dev \
    postgresql-dev

RUN docker-php-ext-install \
    opcache \
    intl \
    pdo \
    pdo_pgsql

WORKDIR /usr/share/nginx/granty

ENTRYPOINT ["php"]
