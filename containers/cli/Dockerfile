FROM ubuntu:14.04
MAINTAINER Paolo Mainardi <paolo@twinbit.it>
ENV REFRESHED_AT 2014-11-24-2

ENV DEBIAN_FRONTEND noninteractive
RUN echo "deb http://archive.ubuntu.com/ubuntu trusty main universe" > /etc/apt/sources.list && \
    apt-get update && \
    apt-get -y dist-upgrade && \
    apt-get install -y python-software-properties software-properties-common && \
    add-apt-repository ppa:chris-lea/node.js -y && \
    apt-get update

# Set timezone and locale.
RUN apt-get install locales && \
    echo "Europe/Rome" > /etc/timezone && \
    dpkg-reconfigure -f noninteractive tzdata && \
    locale-gen en_US.UTF-8 && \
    dpkg-reconfigure locales

RUN apt-get -y install \
    php5-cli \
    php5-curl \
    php5-gd \
    php5-mysql \
    php5-mcrypt \
    curl \
    wget \
    zip \
    git \
    mysql-client \
    build-essential \
    libsqlite3-dev \
    ruby \
    bundler \
    nodejs \
    ruby-dev && \
    npm install -g bower && \
    curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    apt-get clean

# Install cli binaries.
COPY conf/.gemrc /root/.gemrc
COPY conf/composer.json /tmp/composer.json
COPY conf/Gemfile /tmp/Gemfile
WORKDIR /tmp
RUN composer install && \
    bundle install

# add configurations
COPY conf/php.ini /etc/php5/cli/php.ini

# This is needed by bower.
RUN mkdir -p /var/www && \
    chown www-data:www-data /var/www && \
    chown -R www-data:www-data /tmp
USER www-data
WORKDIR /data/var/www
