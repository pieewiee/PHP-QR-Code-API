
FROM php:8.0.6-apache-buster

User root
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd


RUN docker-php-ext-enable sodium

ENTRYPOINT ["docker-php-entrypoint"]
# https://httpd.apache.org/docs/2.4/stopping.html#gracefulstop
STOPSIGNAL SIGWINCH

COPY api /var/www/html
WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
RUN composer require picqer/php-barcode-generator

EXPOSE 80
CMD ["apache2-foreground"]






