FROM php:8.4-apache

RUN a2enmod rewrite

# dependencies used for composer
RUN apt-get update && \
    apt-get install -y git && \
	apt-get install -y zip unzip && \
    apt-get install -y wget

# install php composer
ADD install-composer.sh ./install-composer.sh
RUN chmod ugo+x ./install-composer.sh && \
    ./install-composer.sh

# create data directory
RUN mkdir -p /var/www/html/src/web/data &&  \
    chown 1000:1000 /var/www/html/src/web/data
