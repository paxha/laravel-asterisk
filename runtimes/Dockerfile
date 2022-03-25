FROM ubuntu:21.10

LABEL maintainer="Hassan Raza Pasha"

ARG ASTERISK_VERSION=19
ARG UDP_PORT
ARG MYSQL_DATABASE
ARG MYSQL_USER
ARG MYSQL_PASSWORD

WORKDIR /etc/asterisk

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

RUN apt update  \
    && apt upgrade -y \
    && apt install -y --no-install-recommends --no-install-suggests \
      autoconf \
      binutils-dev \
      build-essential \
      ca-certificates \
      wget \
      curl \
      file \
      libcurl4-openssl-dev \
      libedit-dev \
      libgsm1-dev \
      libogg-dev \
      libpopt-dev \
      libresample1-dev \
      libspandsp-dev \
      libspeex-dev \
      libspeexdsp-dev \
      libsqlite3-dev \
      libsrtp2-dev \
      libssl-dev \
      libvorbis-dev \
      libxml2-dev \
      libxslt1-dev \
      odbcinst \
      portaudio19-dev \
      procps \
      unixodbc \
      odbc-mariadb \
      unixodbc-dev \
      uuid \
      uuid-dev \
      xmlstarlet \
    && cd /usr/src/ \
    && wget http://downloads.asterisk.org/pub/telephony/asterisk/asterisk-${ASTERISK_VERSION}-current.tar.gz \
    && tar zxf asterisk-${ASTERISK_VERSION}-current.tar.gz \
    && cd asterisk-${ASTERISK_VERSION}.*/ \
    && ./configure --with-pjproject-bundled --with-jansson-bundled \
    && make menuselect/menuselect menuselect-tree menuselect.makeopts \
    && make -j $(nproc) \
    && make install \
    && useradd --system asterisk \
    && chown -R asterisk:asterisk /etc/asterisk \
                                  /var/*/asterisk \
                                  /usr/*/asterisk \
    && chmod -R 750 /var/spool/asterisk

COPY odbc.ini /etc/odbc.ini

RUN sed -i "s/MYSQL_DATABASE/$MYSQL_DATABASE/g" /etc/odbc.ini;
RUN sed -i "s/MYSQL_USER/$MYSQL_USER/g" /etc/odbc.ini;
RUN sed -i "s/MYSQL_PASSWORD/$MYSQL_PASSWORD/g" /etc/odbc.ini;

EXPOSE $UDP_PORT/udp

CMD ["asterisk", "-vvvdddf"]
