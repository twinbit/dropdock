FROM stackbrew/ubuntu:14.04
MAINTAINER Paolo Mainardi <paolo@twinbit.it>
ENV REFRESHED_AT 2014-11-24

ENV DEBIAN_FRONTEND noninteractive

RUN echo "deb http://archive.ubuntu.com/ubuntu trusty main universe" > /etc/apt/sources.list && \
    apt-get update && \
    apt-get -y dist-upgrade
RUN apt-get -y install php5-cli php-pear && \
    pear channel-discover pear.drush.org && \
    pear install drush/drush

ENTRYPOINT ["drush"]
