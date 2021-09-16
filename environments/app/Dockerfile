FROM php:8.0.3-fpm-alpine3.13

#
# Install packages
#
RUN apk update \
    && apk add openssl openssl-dev \
    && apk add --no-cache --virtual build-tools autoconf automake libtool gcc libc-dev lcms2-dev nasm make
RUN apk add oniguruma-dev
RUN docker-php-ext-install -j$(nproc) pdo_mysql \
    && docker-php-ext-install -j$(nproc) mysqli \
    && docker-php-ext-install -j$(nproc) mbstring \
    && docker-php-ext-install -j$(nproc) sockets
RUN pecl install redis-5.3.4 xdebug-3.0.4
RUN docker-php-ext-enable redis xdebug

# Install GD
RUN apk add --no-cache libpng libpng-dev
RUN docker-php-ext-install gd

# Purge build tools
RUN apk del --purge build-tools

# Add user
ARG APP_UID
ARG APP_GID
ENV APP_UID ${APP_UID}
ENV APP_GID ${APP_GID}
RUN addgroup -g $APP_GID app
RUN adduser -u $APP_UID -G app -D -H -s /sbin/nologin app

#
# Copy configs
#
COPY php-fpm.conf /usr/local/etc/php-fpm.conf
COPY www.conf     /usr/local/etc/php-fpm.d/www.conf
COPY php.ini      /usr/local/etc/php/php.ini
COPY crontab      /etc/crontabs/app

WORKDIR /var/www/app
USER app
CMD ["php-fpm"]
