FROM ubuntu:21.10

LABEL maintainer="Hassan Raza Pasha"

ARG ASTERISK_VERSION=19
ARG MYSQL_PORT
ARG MYSQL_DATABASE
ARG MYSQL_USER
ARG MYSQL_PASSWORD

ARG DEBIAN_FRONTEND=noninteractive

WORKDIR /etc/asterisk

RUN apt update  \
    && apt upgrade -y \
    && apt install -y wget  \
      build-essential \
      subversion \
      unixodbc \
      odbc-mariadb \
    && cd /usr/src/ \
    && wget http://downloads.asterisk.org/pub/telephony/asterisk/asterisk-${ASTERISK_VERSION}-current.tar.gz \
    && tar zxf asterisk-${ASTERISK_VERSION}-current.tar.gz \
    && cd asterisk-${ASTERISK_VERSION}.*/ \
    && contrib/scripts/get_mp3_source.sh \
    && contrib/scripts/install_prereq install \
    && ./configure \
    && make -j $(nproc) \
    && make install \
    && make config \
    && ldconfig \
    && useradd --system asterisk \
    && chown -R asterisk:asterisk /etc/asterisk \
                                  /var/*/asterisk \
                                  /usr/*/asterisk \
    && chmod -R 750 /var/spool/asterisk

COPY odbc.ini /etc/odbc.ini

RUN sed -i "s/MYSQL_PORT/$MYSQL_PORT/g" /etc/odbc.ini;
RUN sed -i "s/MYSQL_DATABASE/$MYSQL_DATABASE/g" /etc/odbc.ini;
RUN sed -i "s/MYSQL_USER/$MYSQL_USER/g" /etc/odbc.ini;
RUN sed -i "s/MYSQL_PASSWORD/$MYSQL_PASSWORD/g" /etc/odbc.ini;

EXPOSE 5060/udp 4569/udp

CMD ["asterisk", "-vvvdddf"]
