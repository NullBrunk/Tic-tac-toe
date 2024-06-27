FROM composer:2.7.7

# Create the HTML directory to serve the webapp
RUN mkdir -p /var/www/html
WORKDIR /var/www/html/

# Copy all the files from the Git repo to the Docker container
COPY . .

# Publish the php.ini config file
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
RUN apk add pcre-dev "$PHPSIZE_DEPS"

# Install imagemagick (Needed for TFA QRCode)
RUN apk add imagemagick-dev 

# Enable the imagick extension
RUN mkdir -p /usr/src/php/ext/imagick
RUN curl -fsSL https://pecl.php.net/get/imagick | tar xvz -C "/usr/src/php/ext/imagick" --strip 1

# Install & Enable PHP required extensions
RUN docker-php-ext-install imagick pdo_mysql

# Update & Install Laravel vendor
RUN composer update
RUN composer install

# Install deps for the wait-for-mysql script
RUN apk add mariadb-client && apk cache clean
RUN mv wait-for-mysql.sh /

# Ensure that the MySQL container is started and launch migration
RUN echo "/wait-for-mysql.sh" > /init.sh 

RUN chmod +x /wait-for-mysql.sh
RUN chmod +x /init.sh

# Serve the app
RUN echo "php artisan serve --host 0.0.0.0 --port 80" >> /init.sh

# Entrypoint
CMD ["/init.sh"]
