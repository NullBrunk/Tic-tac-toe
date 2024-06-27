FROM composer:2.7.7

# Create the web directory to serve the app
RUN mkdir -p /var/www/html

WORKDIR /var/www/html/

# Copy all the files from the git repo to the container
COPY . .

# Create the php ini config file and install the extensions dependencies
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

# Install some needeed extensions for laravel
RUN docker-php-ext-install pdo_mysql mysqli
RUN apk --no-cache add pcre-dev ${PHPIZE_DEPS}

RUN apk add "$PHPSIZE_DEPS"

# install imagemagick for the qrcode for the 2FA
RUN apk add imagemagick-dev 

# Install && Enable the imagick extension
RUN mkdir -p /usr/src/php/ext/imagick
RUN curl -fsSL https://pecl.php.net/get/imagick | tar xvz -C "/usr/src/php/ext/imagick" --strip 1
RUN docker-php-ext-install imagick

# Update and install the laravel deps
RUN composer update
RUN composer install --no-dev

# Install deps for the wait-for-mysql script
RUN apk add mariadb-client && apk cache clean

RUN mv wait-for-mysql.sh /

# Ensure that the MySQL container is started and launch migration
RUN echo "/wait-for-mysql.sh" > /init.sh 
# Serve the app
RUN echo "php artisan serve --host 0.0.0.0 --port 80" >> /init.sh

RUN chmod +x /wait-for-mysql.sh
RUN chmod +x /init.sh

# Launch it
CMD ["/init.sh"]
