FROM phusion/baseimage:latest

RUN DEBIAN_FRONTEND=noninteractive
RUN locale-gen en_US.UTF-8

ENV LANGUAGE=en_US.UTF-8
ENV LC_ALL=en_US.UTF-8
ENV LC_CTYPE=en_US.UTF-8
ENV LANG=en_US.UTF-8
ENV TERM xterm

ARG TZ=UTC
ENV TZ ${TZ}
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN echo 'DPkg::options { "--force-confdef"; };' >> /etc/apt/apt.conf
RUN add-apt-repository ppa:ondrej/php -y && \
    apt-get update -y && \
    apt-get upgrade -y && \
    apt-get install -y --allow-downgrades --allow-remove-essential --allow-change-held-packages \
        apt-utils \
        ca-certificates \
        software-properties-common



ARG VERSION=8.0
RUN apt-get install -y \
        php${VERSION} \
        php${VERSION}-common \
        php${VERSION}-bcmath \
        php${VERSION}-cli \
        php${VERSION}-curl \
        php${VERSION}-dev \
        php${VERSION}-gd \
        php${VERSION}-igbinary \
        php${VERSION}-imap \
        php${VERSION}-intl \
        php${VERSION}-ldap \
        php${VERSION}-mbstring \
        php${VERSION}-mysql \
        php${VERSION}-opcache \
        php${VERSION}-readline \
        php${VERSION}-sqlite3 \
        php${VERSION}-xml \
        php${VERSION}-zip

RUN apt-get install -y \
        #php${VERSION}-amqp \
        #php${VERSION}-apcu \
        #php${VERSION}-ast \
        php${VERSION}-bz2 \
        #php${VERSION}-cgi \
        #php${VERSION}-dba \
        #php${VERSION}-ds \
        #php${VERSION}-enchant \
        php${VERSION}-fpm \
        #php${VERSION}-gmp \
        #php${VERSION}-imagick \
        #php${VERSION}-imap \
        #php${VERSION}-interbase \
        #php${VERSION}-mailparse \
        #php${VERSION}-memcached \
        #php${VERSION}-mongodb \
        #php${VERSION}-msgpack \
        #php${VERSION}-oauth \
        #php${VERSION}-odbc \
        #php${VERSION}-pcov \
        #php${VERSION}-pgsql \
        #php${VERSION}-phpdbg \
        #php${VERSION}-pspell \
        php${VERSION}-psr \
        #php${VERSION}-raphf \
        #php${VERSION}-redis \
        #php${VERSION}-rrd \
        #php${VERSION}-smbclient \
        #php${VERSION}-snmp \
        #php${VERSION}-soap \
        #php${VERSION}-solr \
        #php${VERSION}-ssh2 \
        #php${VERSION}-sybase \
        #php${VERSION}-tidy \
        php${VERSION}-uuid \
        #php${VERSION}-xhprof \
        #php${VERSION}-xsl \
        #php${VERSION}-yac \
        php${VERSION}-yaml \
        #php${VERSION}-zmq \
        php${VERSION}-xdebug

RUN if [ $(php -r "echo PHP_MAJOR_VERSION;") = "7"]; then \
    apt-get install -y php${VERSION}-json && \
    apt-get install -y php${VERSION}-xmlrpc \
;fi



RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    rm /var/log/lastlog /var/log/faillog

COPY local.ini /etc/php/${VERSION}/cli/conf.d/
COPY xdebug.ini /etc/php/${VERSION}/cli/conf.d/99-xdebug.ini

ARG WORKDIR=/opt/project
WORKDIR ${WORKDIR}
CMD ["php-fpm"]
EXPOSE 9000