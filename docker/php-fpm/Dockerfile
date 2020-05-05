FROM php:7.2-fpm-alpine

ARG GID
ARG UID
ARG APP_ENV

RUN set -xe \
    && apk add --no-cache --update --virtual .phpize-deps $PHPIZE_DEPS \
    && apk add git bash libzip-dev sqlite-dev \
    && docker-php-ext-install zip pdo_mysql pdo_sqlite \
    && pecl install xdebug-2.9.0 \
    && docker-php-ext-enable xdebug \
    && rm -rf /usr/share/php \
    && rm -rf /tmp/* \
    && apk del  .phpize-deps

RUN curl -Ss https://getcomposer.org/installer | php -- --install-dir /usr/local/bin --filename=composer \
    && chmod a+x /usr/local/bin/composer

WORKDIR /var/www

RUN adduser --disabled-password --gecos '' -u $UID -g $GID rdig

USER rdig

# bin/console doctrine:database:create --connection=jobs
# bin/console doctrine:schema:create --em=jobs
CMD composer install; php-fpm

EXPOSE 9000
