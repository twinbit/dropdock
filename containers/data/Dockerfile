FROM ubuntu:14.04
MAINTAINER Paolo Mainardi <paolo@twinbit.it>
ENV REFRESHED_AT 2014-11-24
RUN mkdir -p /data \
    mkdir -p /data/var/www \
    mkdir -p /data/var/log/nginx \
    mkdir -p /data/var/log/mysql \
    mkdir -p /data/var/lib/mysql
ADD build_structure.sh /
RUN chmod +x /build_structure.sh
VOLUME ["/data"]
CMD ["/build_structure.sh"]
