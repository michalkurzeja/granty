FROM php:7.1-alpine

RUN apk --update add \
    autoconf \
    g++ \
    icu-dev \
    make \
    postgresql-dev

RUN docker-php-ext-install \
    intl \
    opcache \
    pdo \
    pdo_pgsql

RUN pecl install \
    xdebug-2.5.0 \
    && docker-php-ext-enable \
    xdebug

WORKDIR /usr/share/nginx/granty

ENTRYPOINT ["php"]
