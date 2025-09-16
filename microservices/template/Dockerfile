FROM php:8.2.4-fpm
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt update -y \
       && apt install git libzip-dev zsh -y
RUN docker-php-ext-install pdo pdo_mysql zip
RUN ln -sf /bin/bash /bin/sh
RUN sh -c "$(wget -O- https://github.com/deluan/zsh-in-docker/releases/download/v1.1.5/zsh-in-docker.sh)"
WORKDIR /template