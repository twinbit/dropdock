FROM ubuntu:14.04
MAINTAINER Paolo Mainardi <paolo@twinbit.it>
ENV REFRESHED_AT 2014-11-24-2

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update && \
    apt-get -y dist-upgrade

# Map www-data user
ENV APACHE_UID 33
ENV APACHE_GID 33
ENV APACHE_HOME /home/www-data

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
    mv composer.phar /usr/local/bin/composer

# Install gosu binary.
RUN curl -o /usr/local/bin/gosu -SL 'https://github.com/tianon/gosu/releases/download/1.0/gosu' \
    && chmod +x /usr/local/bin/gosu

# Init www-data home folder and install PHP composer dependencies.
RUN mkdir -p $APACHE_HOME/.git  && \
    mkdir -p $APACHE_HOME/.ssh  && \
    chown -R www-data:www-data $APACHE_HOME && \
    usermod -d $APACHE_HOME www-data
COPY conf/composer.json $APACHE_HOME/composer.json
RUN cd $APACHE_HOME && \
    composer install && \
    chown -R www-data:www-data $APACHE_HOME

# Fix composer console table dependency.
ADD http://download.pear.php.net/package/Console_Table-1.1.3.tgz /tmp/
RUN tar xzf /tmp/Console_Table-1.1.3.tgz -C $APACHE_HOME/vendor/drush/drush/lib && \
    rm /tmp/Console_Table-1.1.3.tgz

# Install ruby binaries.
WORKDIR /tmp
COPY conf/.gemrc /root/.gemrc
COPY conf/Gemfile /tmp/Gemfile
RUN bundle install

# Add PHP custom configurations.
COPY conf/php-conf.d/opcache.ini /etc/php5/cli/conf.d/php.ini
COPY conf/php-conf.d/docker.ini  /etc/php5/cli/conf.d/docker.ini
COPY run.sh /run.sh
RUN chmod +x /run.sh

# Create folders and expose data volume.
RUN mkdir -p /data/var/www && \
    chown -R www-data:www-data /data/var/www
VOLUME /data

#USER www-data
WORKDIR /data/var/www

# Opinionated start.
ENTRYPOINT ["/run.sh"]
CMD ["bash"]
