# Taken from: https://github.com/zolweb/docker-mailcatcher
FROM ubuntu:14.04
MAINTAINER Lorenzo Mele <lorenzo.mele@agavee.com>
ENV DEBIAN_FRONTEND noninteractive

# install java and wget
RUN apt-get update
RUN apt-get install wget default-jre-headless -y


# download and install solr
WORKDIR /tmp
RUN wget http://archive.apache.org/dist/lucene/solr/4.4.0/solr-4.4.0.tgz
RUN tar -xzvf /tmp/solr-4.4.0.tgz && \
    mv solr-4.4.0 /opt/solr

# adds a blank config
ADD ./solr.xml /opt/solr/example/multicore/solr.xml

# put the startup script
ADD ./run.sh /run.sh
RUN chmod +x /run.sh

EXPOSE 8983

ENTRYPOINT /run.sh