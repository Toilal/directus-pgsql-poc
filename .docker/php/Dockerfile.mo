FROM php:7.3-fpm-stretch
# Use debian stretch instead of buster as a temporary workaround for docker-library/php#865
LABEL maintainer="Rémi Alvergnat <remi.alvergnat@gfi.fr>"
{{#DOCKER_DEVBOX_COPY_CA_CERTIFICATES}}

COPY .ca-certificates/* /usr/local/share/ca-certificates/
RUN update-ca-certificates
{{/DOCKER_DEVBOX_COPY_CA_CERTIFICATES}}

RUN apt-get update -y && apt-get install -y libpng-dev libfreetype6-dev libjpeg62-turbo-dev && rm -rf /var/lib/apt/lists/* \
&& docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
&& docker-php-ext-install gd

RUN yes | pecl install xdebug \
&& echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
&& echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
&& echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN apt-get update -y && apt-get install -y libpq-dev && rm -rf /var/lib/apt/lists/* && docker-php-ext-install pdo pdo_pgsql

RUN docker-php-ext-install pdo pdo_mysql

RUN docker-php-ext-install exif


ENV COMPOSER_HOME /composer
ENV PATH /composer/vendor/bin:$PATH
ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl -fsSL -o /tmp/composer-setup.php https://getcomposer.org/installer \
&& curl -fsSL -o /tmp/composer-setup.sig https://composer.github.io/installer.sig \
&& php -r "if (hash('SHA384', file_get_contents('/tmp/composer-setup.php')) !== trim(file_get_contents('/tmp/composer-setup.sig'))) { unlink('/tmp/composer-setup.php'); echo 'Invalid installer' . PHP_EOL; exit(1); }" \
&& php /tmp/composer-setup.php --no-ansi --install-dir=/usr/local/bin --filename=composer --snapshot && rm -rf /tmp/composer-setup.php \
&& apt-get update -y && apt-get install -y git zip unzip && rm -rf /var/lib/apt/lists/* \
&& composer global require hirak/prestissimo


RUN mkdir -p "$COMPOSER_HOME/cache" \
&& mkdir -p "$COMPOSER_HOME/vendor" \
&& chown -R www-data:www-data $COMPOSER_HOME \
&& chown -R www-data:www-data /var/www

# fixuid
ADD fixuid.tar.gz /usr/local/bin
RUN chown root:root /usr/local/bin/fixuid && \
    chmod 4755 /usr/local/bin/fixuid && \
    mkdir -p /etc/fixuid
COPY php/fixuid.yml /etc/fixuid/config.yml
USER www-data

VOLUME /composer/cache

