# base image
FROM php:8.2.17-apache
SHELL ["/bin/bash", "-c"]

# update package index
RUN apt-get update

# install dependencies
RUN apt-get install -y git mariadb-server libzip-dev zip libxml2-dev libpng-dev sudo
RUN docker-php-ext-install gd intl mysqli simplexml soap zip

# obtain Moodle
ARG ADDRESSPATH=/
ENV MOODLEREPOPATH=/var/www/html/${ADDRESSPATH}
RUN mkdir -p "${MOODLEREPOPATH}"
RUN git clone -b MOODLE_405_STABLE --depth 1 --verbose https://github.com/moodle/moodle.git "${MOODLEREPOPATH}"

# obtain HarpIA Survey plugins
ADD https://api.github.com/repos/C4AI/moodle-datafield_harpiainteraction/git/refs/heads/main "/harpia/moodle-datafield_harpiainteraction-head.json"
RUN git clone -b main --single-branch --depth 1 --verbose https://github.com/C4AI/moodle-datafield_harpiainteraction.git "${MOODLEREPOPATH}/mod/data/field/harpiainteraction"
RUN cp "${MOODLEREPOPATH}/mod/data/field/harpiainteraction/pix/harpiainteraction.svg" "${MOODLEREPOPATH}/mod/data/pix/field/harpiainteraction.svg"
ADD https://api.github.com/repos/C4AI/moodle-local_harpiaajax/git/refs/heads/main "/harpia/moodle-local_harpiaajax-head.json"
RUN git clone -b main --single-branch --depth 1 --verbose https://github.com/C4AI/moodle-local_harpiaajax.git "${MOODLEREPOPATH}/local/harpiaajax"

# copy HarpIA setup files
COPY "src/setup/" "/harpia/src/"
COPY "src/defaults.php" "${MOODLEREPOPATH}/local/defaults.php"
COPY "src/custom_translations" "/harpia/custom_translations"

# copy HarpIA Survey translation files
COPY "src/plugin_translations/moodle-datafield_harpiainteraction/pt_br" "${MOODLEREPOPATH}/mod/data/field/harpiainteraction/lang/pt_br"
COPY "src/plugin_translations/moodle-local_harpiaajax/pt_br" "${MOODLEREPOPATH}/local/harpiaajax/lang/pt_br"

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
