FROM php:8.4-fpm-alpine

WORKDIR /var/www/html

RUN apk add --no-cache \
    linux-headers \
    unzip \
    libzip-dev \
    gcc \
    g++ \
    make \
    autoconf \
    && pecl install xdebug \
    && docker-php-ext-install zip \
    && docker-php-ext-enable xdebug \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN addgroup -g 1000 opengraph\
    && adduser -D -u 1000 -G opengraph opengraph

USER opengraph
