FROM php:8.0.1
FROM composer:2.0 as composer

COPY . .
WORKDIR .
RUN composer install

RUN cd src
EXPOSE 80
EXPOSE 8000

ENTRYPOINT ["php", "-S", "localhost:8000", "./router.php"]

# RUN apt-get update && apt-get install
# RUN docker-php-ext-install pdo_mysql

# RUN pecl install apcu

# RUN apt-get update && \
# apt-get install -y \
# libzip-dev

# RUN docker-php-ext-install zip
# RUN docker-php-ext-enable apcu
