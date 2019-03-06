FROM composer:1.7.3 AS composer
RUN composer global require hirak/prestissimo
WORKDIR /app
COPY composer.json .
RUN composer install --ignore-platform-reqs --no-scripts

#For later maybe?
FROM node:current-alpine AS NodeJs
COPY package.json ./
RUN npm install

FROM php:7.3-fpm-alpine
RUN apk add --update --no-cache libpng-dev libmcrypt-dev unixodbc-dev libxml2-dev build-base autoconf libzip libcurl curl libzip-dev curl-dev \
    && docker-php-ext-configure pdo_odbc --with-pdo-odbc=unixODBC,/usr \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql pdo_odbc xml json zip curl \
    && pecl install mcrypt-1.0.2 \
    && docker-php-ext-enable mcrypt \
    && apk del autoconf g++ make build-base \
    && rm -rf /var/cache/apk/*
COPY . .
COPY --from=NodeJs /node_modules /var/www/html/webroot/lib
COPY --from=composer /app/vendor /var/www/html/vendor
COPY --from=composer /app/composer.lock /var/www/html/composer.lock
RUN chown -R www-data:www-data /var/www/html
USER www-data
