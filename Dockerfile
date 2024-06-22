ARG PHP_VERSION=8.3.6

FROM php:${PHP_VERSION}-fpm-alpine

## Copy builder user to mac system as dev
ARG USER_ID
ARG GROUP_ID
RUN echo "dev:x:$USER_ID:$USER_ID::/home/dev:" >> /etc/passwd && \
    echo "dev:!:$(($(date +%s) / 60 / 60 / 24)):0:99999:7:::" >> /etc/shadow  && \
    echo "dev:x:$USER_ID:" >> /etc/group  && \
    mkdir /home/dev && chown dev: /home/dev

# Install system dependencies
RUN apk --no-cache update && \
    apk --no-cache add \
        $PHPIZE_DEPS \
        icu-dev \
        zlib-dev \
        libzip-dev \
        bash \
        mysql-client \
        gettext-dev \
        libintl \
        libpng-dev \
        freetype-dev \
        libjpeg-turbo-dev

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    intl \
    opcache \
    zip \
    gd

# Add composer manager
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
	php composer-setup.php --install-dir=/usr/local/bin --filename=composer

USER dev

WORKDIR /var/www/html
COPY workspace/. ./

# Image Cleaner
RUN rm -rf /var/cache/apk/*

EXPOSE 9000
CMD ["php-fpm"]
