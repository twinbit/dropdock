FROM ubuntu:14.04
MAINTAINER Paolo Mainardi <paolo@twinbit.it>
ENV REFRESHED_AT 2014-11-24-2

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update && \
    apt-get -y dist-upgrade

# Set timezone and locale.
ENV LANGUAGE en_US.UTF-8
ENV LANG en_US.UTF-8
ENV LC_ALL en_US.UTF-8
RUN apt-get install locales && \
    echo "Europe/Rome" > /etc/timezone && \
    dpkg-reconfigure -f noninteractive tzdata && \
    locale-gen en_US.UTF-8 && \
    dpkg-reconfigure locales

# Use nodejs from ppa:chris-lea repository.
RUN apt-get install -y python-software-properties software-properties-common && \
    add-apt-repository ppa:chris-lea/node.js -y

# USE php5.6 from ppa:ondrej repository.
#RUN add-apt-repository ppa:ondrej/php5-5.6 -y

RUN apt-get update && \
    apt-get -y install \
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
    apt-get clean && \
    mkdir -p /home/www-data/.git  && \
    mkdir -p /home/www-data/.ssh  && \
    chown -R www-data:www-data /home/www-data && \
    usermod -d /home/www-data www-data

# Install cli binaries.
COPY conf/.gemrc /root/.gemrc
COPY conf/composer.json /tmp/composer.json
COPY conf/Gemfile /tmp/Gemfile
WORKDIR /tmp
RUN composer install && \
    chown -R www-data:www-data /tmp/vendor && \
    bundle install

# add configurations
COPY conf/php-conf.d/opcache.ini /etc/php5/cli/conf.d/php.ini
COPY conf/php-conf.d/docker.ini  /etc/php5/cli/conf.d/docker.ini
COPY run.sh /run.sh
RUN chmod +x /run.sh

USER www-data
WORKDIR /data/var/www

# Opinionated start.
ENTRYPOINT ["/run.sh"]
CMD ["bash"]
