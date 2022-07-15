FROM php:8.0.18 as php-base
WORKDIR /build
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    vim \
    && pecl install \
    redis \
    && docker-php-ext-install \
    zip \
    pdo \
    pdo_mysql \
    && docker-php-ext-enable \
    redis \
    && apt purge -y $PHPIZE_DEPS \
    && apt autoremove -y --purge \
    && apt clean all

ENV COMPOSER_HOME /.composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# PHP-BUILD
FROM php-base as php-build
COPY composer.lock composer.json ./
RUN composer install --prefer-dist --no-suggest --no-cache --no-autoloader
COPY --chown=www-data:www-data . .
RUN composer dump-autoload -o --apcu

# PHP-RUNTIME
FROM php-base as php-runtime
USER www-data
WORKDIR /app
COPY --chown=www-data:www-data --from=php-build /build .

CMD ["vendor/bin/phpunit"]
