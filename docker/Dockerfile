FROM centos:7
#FROM php:8.0.6-apache-buster
#ENV PORT 8080

USER root


RUN yum update -y
RUN yum-config-manager --enable remi-php72
RUN yum update -y
RUN yum install -y httpd php freetype-devel libjpeg-turbo-devel libpng-devel unzip php-gd.x86_64
RUN curl https://packages.microsoft.com/config/rhel/7/prod.repo | tee /etc/yum.repos.d/microsoft.repo
RUN yum update -y
RUN yum install -y powershell nano




RUN echo 'DocumentRoot "/var/www/html"' >> /etc/httpd/conf/httpd.conf
RUN sed -i "s/Listen.*/Listen 80/" /etc/httpd/conf/httpd.conf
RUN chmod 777 /run/httpd
RUN sed -i 's/ErrorLog.*/ErrorLog "|\/usr\/bin\/cat"/' /etc/httpd/conf/httpd.conf
RUN sed -i 's/CustomLog.*/CustomLog "|\/usr\/bin\/cat" combined/' /etc/httpd/conf/httpd.conf



COPY api /var/www/html
WORKDIR /var/www/html/api

RUN curl -sS https://getcomposer.org/installer | php
RUN mv -f composer.phar /usr/local/bin/composer 
#RUN ccomposer require jucksearm/php-barcode

EXPOSE 80


CMD /usr/sbin/httpd -D FOREGROUND