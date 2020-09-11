FROM php:7.4-fpm

RUN apt-get update && apt-get install -y libicu-dev

# Install Postgre PDO
RUN apt-get install -y libpq-dev zip unzip \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql json
RUN apt-get clean

RUN pecl install apcu
RUN docker-php-ext-enable apcu
RUN docker-php-ext-install intl opcache

RUN apt-get install -y wget
RUN wget https://getcomposer.org/installer -O composer-setup.php
RUN php composer-setup.php
RUN mv composer.phar /usr/local/bin/composer

WORKDIR /usr/share/nginx/html