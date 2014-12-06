FROM ubuntu:14.04
MAINTAINER Paolo Mainardi <paolo@twinbit.it>
ENV REFRESHED_AT 2014-11-24
ADD build_structure.sh /
RUN chmod +x /build_structure.sh
VOLUME ["/data"]
CMD ["/build_structure.sh"]
