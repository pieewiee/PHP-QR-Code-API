FROM php:8.0.6-apache-buster
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

EXPOSE 80
CMD ["apache2-foreground"]
