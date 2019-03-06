FROM composer:1.7.3 AS composer
RUN composer global require hirak/prestissimo
WORKDIR /app
COPY composer.json .
RUN composer install --ignore-platform-reqs --no-scripts && composer clearcache

FROM node:11.10-alpine AS nodejs
COPY package.json .
RUN yarn install && yarn autoclean

FROM php:7.3-fpm-alpine
RUN apk add -U --no-cache libpng-dev libmcrypt-dev unixodbc-dev libxml2-dev build-base autoconf \
    && docker-php-ext-configure pdo_odbc --with-pdo-odbc=unixODBC,/usr \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql pdo_odbc xml json \
    && pecl install mcrypt-1.0.2 \
    && docker-php-ext-enable mcrypt \
    && pecl clear-cache \
    && apk del --purge autoconf g++ make build-base \
    && rm -rf /var/cache/apk/* /usr/src/* /tmp/* /usr/lib/php/build
COPY --chown=www-data:www-data . .
COPY --chown=www-data:www-data --from=nodejs /node_modules /var/www/html/webroot/lib
COPY --chown=www-data:www-data --from=composer /app/vendor /var/www/html/vendor
COPY --chown=www-data:www-data --from=composer /app/composer.lock /var/www/html/composer.lock

USER www-data