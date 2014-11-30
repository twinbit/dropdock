FROM nginx:1.7.7
MAINTAINER Paolo Mainardi <paolo@twinbit.it>
ENV REFRESHED_AT 2014-11-24-7
ADD conf/nginx.conf /etc/nginx/nginx.conf

# Change the mysql uid to 1000 in order to make it works nicely on b2d
# See this issue: https://github.com/boot2docker/boot2docker/issues/581
RUN usermod -u 1000 www-data

EXPOSE 80
ENTRYPOINT ["nginx"]
