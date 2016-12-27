FROM php:7.1-fpm-alpine

RUN apk --update add \
    acl \
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

RUN pecl install xdebug-2.5.0 \
    && docker-php-ext-enable xdebug

RUN echo "xdebug.remote_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_autostart=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_connect_back=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_host=192.168.65.1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

ADD template/set-acl.sh /set-acl.sh
