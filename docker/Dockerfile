FROM registry.access.redhat.com/rhel7
#FROM php:8.0.6-apache-buster
#ENV PORT 8080

USER root

RUN yum update
RUN yum-config-manager --enable remi-php72
RUN yum update
RUN yum install -y httpd php freetype-devel libjpeg-turbo-devel libpng-devel unzip php-gd.x86_64





RUN echo 'DocumentRoot "/var/www/html"' >> /etc/httpd/conf/httpd.conf
RUN sed -i "s/Listen.*/Listen 80/" /etc/httpd/conf/httpd.conf
RUN chmod 777 /run/httpd
RUN sed -i 's/ErrorLog.*/ErrorLog "|\/usr\/bin\/cat"/' /etc/httpd/conf/httpd.conf
RUN sed -i 's/CustomLog.*/CustomLog "|\/usr\/bin\/cat" combined/' /etc/httpd/conf/httpd.conf



COPY api /var/www/html
WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
RUN composer require picqer/php-barcode-generator

EXPOSE 80
USER 1001


CMD /usr/sbin/httpd -D FOREGROUND