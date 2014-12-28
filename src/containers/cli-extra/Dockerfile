FROM twinbit/docker-drupal-cli:latest
MAINTAINER Paolo Mainardi <paolo@twinbit.it>
ENV REFRESHED_AT 2014-12-22-3

ENV DEBIAN_FRONTEND noninteractive

# Install ruby binaries.
WORKDIR /tmp
COPY conf/Gemfile /tmp/Gemfile
RUN bundle install

VOLUME /data
WORKDIR /data/var/www

# Opinionated start.
ENTRYPOINT ["/run.sh"]
CMD ["bash"]
