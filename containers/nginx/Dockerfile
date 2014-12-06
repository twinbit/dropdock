FROM ubuntu:14.04

MAINTAINER "Paolo Mainardi" <paolo@twinbit.it>

WORKDIR /tmp

# Install Nginx
RUN apt-get update -y && \
    apt-get install -y nginx

# Apply Nginx configuration
ADD conf/nginx.conf /opt/etc/nginx.conf
ADD conf/drupal /etc/nginx/sites-available/drupal
RUN ln -s /etc/nginx/sites-available/drupal /etc/nginx/sites-enabled/drupal && \
    rm /etc/nginx/sites-enabled/default

# Nginx startup script
ADD conf/nginx-start.sh /opt/bin/nginx-start.sh
RUN chmod u=rwx /opt/bin/nginx-start.sh

# PORTS
EXPOSE 80 443

WORKDIR /opt/bin
ENTRYPOINT ["/opt/bin/nginx-start.sh"]
