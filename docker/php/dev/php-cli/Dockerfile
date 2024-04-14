FROM php:8.3-cli

RUN apt-get update
RUN apt-get install -y apt-utils \
    curl \
    libpq-dev \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    apt-transport-https \
    lsb-release \
    ca-certificates \
    wget


RUN docker-php-ext-install pdo_mysql pcntl
RUN docker-php-ext-configure exif
RUN docker-php-ext-install exif
RUN docker-php-ext-enable exif

RUN curl -sS https://getcomposer.org/installer | php --  --filename=composer --install-dir=/usr/local/bin

USER 1000:1000

WORKDIR /var/www
