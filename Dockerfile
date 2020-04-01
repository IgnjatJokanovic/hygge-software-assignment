FROM php:7.3-apache

RUN apt-get update \
  && apt-get install -y vim git zlib1g-dev mariadb-client libzip-dev \
  && docker-php-ext-install zip mysqli pdo_mysql \
  && a2enmod rewrite \
  && curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer \
  && chmod -R 777 /var/www/ 
WORKDIR /var/www/project
