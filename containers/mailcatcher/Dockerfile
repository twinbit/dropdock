# Taken from: https://github.com/zolweb/docker-mailcatcher
FROM ubuntu:14.04
MAINTAINER Paolo Mainardi <paolo@twinbit.it>
ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    ruby \
    ruby-dev \
    rubygems

RUN gem install mailcatcher

EXPOSE 1080
EXPOSE 1025

ENTRYPOINT ["mailcatcher", "--smtp-ip=0.0.0.0", "--http-ip=0.0.0.0", "--foreground"]
