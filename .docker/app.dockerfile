FROM php:7.2-fpm

#RUN pecl install redis-4.0.1 \
#    && pecl install xdebug-2.6.0 \
#    && docker-php-ext-enable redis xdebug

#RUN apt-get update && apt-get install -y libmcrypt-dev \
#    mysql-client libmagickwand-dev --no-install-recommends \
#    && pecl install imagick \
#    && pecl install mcrypt \
#    && docker-php-ext-enable imagick \
#    && docker-php-ext-install mcrypt pdo_mysql

# Update packages and install composer and PHP dependencies.
RUN apt-get update && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y \
    mysql-client \
    libpq-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libbz2-dev

# PHP Extensions
RUN docker-php-ext-install zip bz2 mbstring pdo pdo_pgsql pdo_mysql pcntl \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd

# Memory Limit
RUN echo "memory_limit=2048M" > $PHP_INI_DIR/conf.d/memory-limit.ini
RUN echo "max_execution_time=900" >> $PHP_INI_DIR/conf.d/memory-limit.ini
#RUN echo "extension=apcu.so" > $PHP_INI_DIR/conf.d/apcu.ini
RUN echo "post_max_size=20M" >> $PHP_INI_DIR/conf.d/memory-limit.ini
RUN echo "upload_max_filesize=20M" >> $PHP_INI_DIR/conf.d/memory-limit.ini
RUN echo "extension=pdo_mysql.so" >> $PHP_INI_DIR/conf.d/php.ini

# Time Zone
RUN echo "date.timezone=${PHP_TIMEZONE:-UTC}" > $PHP_INI_DIR/conf.d/date_timezone.ini

# Display errors in stderr
RUN echo "display_errors=stderr" > $PHP_INI_DIR/conf.d/display-errors.ini

# Disable PathInfo
RUN echo "cgi.fix_pathinfo=0" > $PHP_INI_DIR/conf.d/path-info.ini

# Disable expose PHP
RUN echo "expose_php=0" > $PHP_INI_DIR/conf.d/path-info.ini