FROM debian:jessie
MAINTAINER Paolo Mainardi <paolo@twinbit.it>
ENV REFRESHED_AT 2014-11-24
VOLUME ["/data"]
COPY build_structure.sh /build_structure.sh
RUN chmod +x /build_structure.sh
CMD ["/build_structure.sh"]
