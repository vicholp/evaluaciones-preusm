FROM centos:centos7

RUN yum -y update

RUN yum -y install \
    yum-utils epel-release \
    curl git \
    zip unzip

RUN yum -y install \
    http://rpms.remirepo.net/enterprise/remi-release-7.rpm \
    https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm

RUN yum-config-manager --enable remi-php81 && yum -y update

RUN yum -y install httpd php

RUN yum -y install \
    php-pdo \
    php-mbstring \
    php-soap \
    php-xml \
    php-pdo_mysql \
    php-exif \
    php-bcmath \
    php-gd \
    php-pecl-zip

COPY httpd.conf /etc/httpd/conf/httpd.conf

COPY php.ini /etc/php.ini

ENTRYPOINT /usr/sbin/httpd -DFOREGROUND

WORKDIR /var/www/html
