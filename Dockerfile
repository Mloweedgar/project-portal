FROM php:7.2-fpm-alpine3.12

RUN docker-php-ext-install pdo pdo_mysql sockets

WORKDIR /app
COPY . .