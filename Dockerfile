FROM composer:1.7.3 AS composer
RUN composer global require hirak/prestissimo
WORKDIR /app
COPY composer.json .
RUN composer install --ignore-platform-reqs --no-scripts

FROM node:11.10-alpine AS nodejs
COPY package.json .
RUN yarn install

FROM php:7.3-fpm-alpine
RUN apk add -U --no-cache libpng-dev libmcrypt-dev unixodbc-dev libxml2-dev build-base autoconf \
    && docker-php-ext-configure pdo_odbc --with-pdo-odbc=unixODBC,/usr \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql pdo_odbc xml json \
    && pecl install mcrypt-1.0.2 \
    && docker-php-ext-enable mcrypt \
    && apk del autoconf g++ make build-base \
    && rm -rf /var/cache/apk/* /usr/src/*
COPY . .
COPY --from=nodejs /node_modules /var/www/html/webroot/lib
COPY --from=composer /app/vendor /var/www/html/vendor
COPY --from=composer /app/composer.lock /var/www/html/composer.lock
RUN chown -R www-data:www-data /var/www/html
USER www-data