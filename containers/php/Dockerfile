FROM ubuntu:14.04
MAINTAINER Paolo Mainardi <paolo@twinbit.it>
ENV REFRESHED_AT 2014-11-24

ENV DEBIAN_FRONTEND noninteractive

# Configure default system.
RUN echo "deb http://archive.ubuntu.com/ubuntu trusty main universe" > /etc/apt/sources.list && \
    apt-get update && \
    apt-get -y dist-upgrade && \
    apt-get update

# Set timezone and locale.
ENV LANGUAGE en_US.UTF-8
ENV LANG en_US.UTF-8
ENV LC_ALL en_US.UTF-8
RUN apt-get install locales && \
    echo "Europe/Rome" > /etc/timezone && \
    dpkg-reconfigure -f noninteractive tzdata && \
    locale-gen en_US.UTF-8 && \
    dpkg-reconfigure locales

# USE php5.6 from ppa:ondrej
RUN apt-get -y install python-software-properties software-properties-common && \
    add-apt-repository ppa:ondrej/php5-5.6 -y && \
    apt-get update

# UPD
RUN apt-get -y install php5 php5-fpm php5-gd php5-ldap \
    php5-sqlite php5-pgsql php-pear php5-mysql php5-curl \
    php5-mcrypt php5-xcache php5-xmlrpc php5-intl php5-xdebug \
    build-essential \
    libsqlite3-dev \
    ruby \
    ruby-dev

# We need this just for catchmail binary.
RUN gem install mailcatcher --version 0.5.12 --no-rdoc --no-ri

RUN sed -i '/daemonize /c \
daemonize = no' /etc/php5/fpm/php-fpm.conf

RUN sed -i '/^listen /c \
listen = 0.0.0.0:9000' /etc/php5/fpm/pool.d/www.conf
RUN sed -i 's/^listen.allowed_clients/;listen.allowed_clients/' /etc/php5/fpm/pool.d/www.conf

# Add configurations.
# COPY conf/php.ini /etc/php5/fpm/php.ini
COPY conf/conf.d/opcache.ini /etc/php5/fpm/conf.d/opcache.ini
COPY conf/conf.d/docker.ini /etc/php5/fpm/conf.d/docker.ini
COPY conf/php-fpm.conf /etc/php5/fpm/pool.d/www.conf

EXPOSE 9000
ENTRYPOINT ["php5-fpm"]
