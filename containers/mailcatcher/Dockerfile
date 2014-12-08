# Taken from: https://github.com/zolweb/docker-mailcatcher
FROM ubuntu:14.04
MAINTAINER Paolo Mainardi <paolo@twinbit.it>
ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update && apt-get install -y \
    build-essential \
    libsqlite3-dev \
    ruby \
    ruby-dev

RUN gem install mailcatcher --version 0.5.12 --no-rdoc --no-ri

EXPOSE 1080
EXPOSE 1025

ENTRYPOINT ["mailcatcher", "--smtp-ip=0.0.0.0", "--http-ip=0.0.0.0", "--foreground"]
