FROM php:8.0.1
FROM composer:2.0 as composer

COPY . /app
WORKDIR /app
RUN composer install

# RUN cd src
EXPOSE 80
WORKDIR /app/src

ENTRYPOINT ["php", "-S", "0.0.0.0:80", "/app/src/router.php"]

# RUN apt-get update && apt-get install
# RUN docker-php-ext-install pdo_mysql

# RUN pecl install apcu

# RUN apt-get update && \
# apt-get install -y \
# libzip-dev

# RUN docker-php-ext-install zip
# RUN docker-php-ext-enable apcu
