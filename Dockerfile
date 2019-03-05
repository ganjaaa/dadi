FROM composer:1.7.3 AS composer
RUN composer global require hirak/prestissimo
WORKDIR /app
COPY composer.json .
RUN composer install --ignore-platform-reqs --no-scripts

#For later maybe?
#FROM nodejs:latest AS NodeJs

FROM php:7.3-fpm-alpine
RUN apk add -U libpng-dev libmcrypt-dev unixodbc-dev libxml2-dev build-base autoconf
RUN docker-php-ext-configure pdo_odbc --with-pdo-odbc=unixODBC,/usr
RUN docker-php-ext-install -j$(nproc) gd pdo pdo_mysql pdo_odbc xml json
RUN pecl install mcrypt-1.0.2
RUN docker-php-ext-enable mcrypt
COPY . .
COPY --from=composer /app/vendor /var/www/html/vendor
COPY --from=composer /app/composer.lock /var/www/html/composer.lock
RUN chown -R www-data:www-data /var/www/html
USER www-data
