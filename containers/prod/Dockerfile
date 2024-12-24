# base image
FROM php:8.2.17-apache

# update package index
RUN apt-get update

# install dependencies
RUN apt-get install -y git mariadb-server libzip-dev zip libxml2-dev libpng-dev sudo
RUN docker-php-ext-install gd intl mysqli simplexml soap zip

# obtain Moodle
RUN git clone -b MOODLE_405_STABLE --depth 1 --verbose https://github.com/moodle/moodle.git /var/www/html/moodle

# obtain HarpIA Survey plugins
ADD https://api.github.com/repos/C4AI/moodle-datafield_harpiainteraction/git/refs/heads/main /harpia/moodle-datafield_harpiainteraction-head.json
RUN git clone -b main --single-branch --depth 1 --verbose https://github.com/C4AI/moodle-datafield_harpiainteraction.git /var/www/html/moodle/mod/data/field/harpiainteraction
RUN cp /var/www/html/moodle/mod/data/field/harpiainteraction/pix/harpiainteraction.svg /var/www/html/moodle/mod/data/pix/field/harpiainteraction.svg
ADD https://api.github.com/repos/C4AI/moodle-local_harpiaajax/git/refs/heads/main /harpia/moodle-local_harpiaajax-head.json
RUN git clone -b main --single-branch --depth 1 --verbose https://github.com/C4AI/moodle-local_harpiaajax.git /var/www/html/moodle/local/harpiaajax

# copy HarpIA setup files
COPY src/setup/ /harpia/src/
COPY src/defaults.php /var/www/html/moodle/local/defaults.php

# copy HarpIA Survey translation files
COPY src/plugin_translations/moodle-datafield_harpiainteraction/pt_br /var/www/html/moodle/mod/data/field/harpiainteraction/lang/pt_br
COPY src/plugin_translations/moodle-local_harpiaajax/pt_br /var/www/html/moodle/local/harpiaajax/lang/pt_br

# change settings
RUN echo 'max_input_vars=10000' > /usr/local/etc/php/conf.d/docker-php-moodle.ini
RUN echo '[mysqld]\ndatadir=/harpia/data/db' > /etc/mysql/conf.d/harpia.cnf

# change working directory
WORKDIR /var/www


# change default command
SHELL ["/bin/bash", "-c"]
CMD service mariadb start && apache2-foreground
