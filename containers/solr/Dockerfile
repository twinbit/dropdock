FROM ubuntu:14.04
MAINTAINER Lorenzo Mele <lorenzo.mele@agavee.com>
ENV DEBIAN_FRONTEND noninteractive

ENV SOLR_VERSION 4.10.2
ENV SOLR solr-$SOLR_VERSION

# install java and wget
RUN apt-get update && \
    apt-get install -y \
    curl \
    openjdk-7-jre-headless \
    unzip \
    wget \
    lsof \
    curl \
    procps

# download and install solr
WORKDIR /tmp
RUN mkdir -p /opt && \
    wget --progress=bar:force --output-document=/opt/$SOLR.tgz http://www.mirrorservice.org/sites/ftp.apache.org/lucene/solr/$SOLR_VERSION/$SOLR.tgz && \
    tar -C /opt --extract --file /opt/$SOLR.tgz && \
    rm /opt/$SOLR.tgz && \
    ln -s /opt/$SOLR /opt/solr

# Copy search_api_solr 4.x configuration
COPY conf/* /opt/solr/example/solr/collection1/conf/

EXPOSE 8983
WORKDIR /opt/solr/example
ENTRYPOINT ["java"]
CMD ["-Xmx512m", "-DSTOP.PORT=8079", "-DSTOP.KEY=stopkey", "-jar", "start.jar"]
