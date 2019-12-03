FROM php:7.3-apache

RUN apt-get update && apt-get install -y \
    git-core

RUN docker-php-ext-install -j$(nproc) pdo_mysql
RUN docker-php-ext-install -j$(nproc) opcache

RUN apt-get update && apt-get install -y \
    libzip-dev unzip \
    && docker-php-ext-install -j$(nproc) zip

RUN pecl install xdebug && docker-php-ext-enable xdebug \
    && echo "xdebug.remote_enable=On" >> $PHP_INI_DIR/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=On" >> $PHP_INI_DIR/conf.d/xdebug.ini \
    && echo "xdebug.remote_connect_back=On" >> $PHP_INI_DIR/conf.d/xdebug.ini \
    && echo "xdebug.idekey=PHPSTORM" >> $PHP_INI_DIR/conf.d/xdebug.ini

RUN pecl install apcu \
  && docker-php-ext-enable apcu
RUN a2enmod rewrite

WORKDIR /var/www

RUN usermod -u 1000 www-data

RUN mkdir -p var/cache var/logs var/sessions && \
    chmod -R 777 var/cache var/logs var/sessions

ENV DOCKER true
