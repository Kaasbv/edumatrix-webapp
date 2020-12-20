FROM php:7.4-apache

# Update image
RUN apt-get update && apt-get install -y

# Create and set service user
ENV APACHE_RUN_USER=apache
ENV APACHE_RUN_GROUP=apache
RUN useradd -M -u 1000 apache

# Install Xdebug
RUN curl -fsSL 'https://xdebug.org/files/xdebug-2.7.2.tgz' -o xdebug.tar.gz \
    && mkdir -p xdebug \
    && tar -xf xdebug.tar.gz -C xdebug --strip-components=1 \
    && rm xdebug.tar.gz \
    && ( \
    cd xdebug \
    && phpize \
    && ./configure --enable-xdebug \
    && make -j$(nproc) \
    && make install \
    ) \
    && rm -r xdebug \
    && docker-php-ext-enable xdebug

# COPY php.ini /usr/local/etc/php/php.ini
RUN echo "[xdebug]" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_connect_back=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_host=host.docker.internal" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN docker-php-ext-install pdo_mysql 
RUN docker-php-ext-install mysqli

RUN a2enmod rewrite && a2enmod headers