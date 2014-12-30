FROM ubuntu:14.04
MAINTAINER Paolo Mainardi <paolo@twinbit.it>
ENV REFRESHED_AT 2014-11-24

ENV DEBIAN_FRONTEND noninteractive

# Configure default system.
RUN apt-get update && \
    apt-get -y dist-upgrade

# Set timezone and locale.
RUN locale-gen en_US.UTF-8
ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8

# USE php5.6 from ppa:ondrej
#RUN apt-get -y install python-software-properties software-properties-common && \
#    add-apt-repository ppa:ondrej/php5-5.6 -y && \
#    apt-get update

# PHP Packages.
RUN apt-get -y install php5 php5-fpm php5-gd php5-ldap \
    php5-sqlite php5-pgsql php-pear php5-mysql php5-curl \
    php5-mcrypt php5-xcache php5-xmlrpc php5-intl php5-xdebug \
    build-essential \
    libsqlite3-dev \
    ruby \
    ruby-dev \
    bindfs

# We need this just for catchmail binary.
RUN gem install mailcatcher --version 0.5.12 --no-rdoc --no-ri

# Configure php-fpm.
RUN sed -i '/daemonize /c \
daemonize = no' /etc/php5/fpm/php-fpm.conf && \
    sed -i '/^listen /c \
listen = 0.0.0.0:9000' /etc/php5/fpm/pool.d/www.conf && \
    sed -i 's/^listen.allowed_clients/;listen.allowed_clients/' /etc/php5/fpm/pool.d/www.conf

# Add configurations.
COPY conf/conf.d/opcache.ini /etc/php5/fpm/conf.d/opcache.ini
COPY conf/conf.d/docker.ini /etc/php5/fpm/conf.d/docker.ini
COPY conf/php-fpm.conf /etc/php5/fpm/pool.d/www.conf
COPY run.sh /run.sh
RUN chmod +x /run.sh

EXPOSE 9000
ENTRYPOINT ["/run.sh"]
CMD ["php5-fpm"]
