# base image
FROM php:8.2.17-apache
SHELL ["/bin/bash", "-c"]

# update package index
RUN apt-get update

# install dependencies
RUN apt-get install -y git mariadb-server libzip-dev zip libxml2-dev libpng-dev sudo
RUN docker-php-ext-install gd intl mysqli simplexml soap zip

# obtain Moodle
ENV MOODLEREPOPATH=/var/www/html/
RUN mkdir -p "${MOODLEREPOPATH}"
RUN git clone -b MOODLE_405_STABLE --single-branch  --depth 1 --verbose https://github.com/moodle/moodle.git "${MOODLEREPOPATH}"

# change settings
RUN echo 'max_input_vars=10000' > /usr/local/etc/php/conf.d/docker-php-moodle.ini
RUN echo -e '[mysqld]\ndatadir=/harpia/data/db' > /etc/mysql/conf.d/harpia.cnf

# change working directory
WORKDIR /var/www

# define user to prevent permission errors
ARG UNAME=www-data
ARG UGROUP=www-data
ARG UID=1000
ARG GID=1001
RUN usermod --uid $UID $UNAME
RUN groupmod --gid $GID $UGROUP

# change default command
CMD service mariadb start && apache2-foreground
