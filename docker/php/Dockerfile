FROM php:8.0-cli-alpine
LABEL maintainer="Saeed Nourzaei <skhammari@gmail.com>"

# persistent / runtime deps (eg. dependencies for gd extension)
RUN apk add --no-cache \
        $PHPIZE_DEPS \
        wget \
        curl \
        git \
        zip \
        unzip \
        bash \
        libmcrypt-dev \
        libjpeg-turbo-dev \
		libpng-dev \
        freetype-dev \
        icu-dev \
        g++ \
        make \
        autoconf 

# Install PHP Xdebug Extension
#RUN pecl install xdebug \
#    && docker-php-ext-enable xdebug

RUN set -eux; \ 
    # Install the PHP extentions
    docker-php-ext-install bcmath exif pdo_mysql intl;

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# Override with custom symfony settings
COPY ./symfony.ini $PHP_INI_DIR/conf.d/
# Copy xdebug configuration for remote debugging
#COPY ./xdebug.ini $PHP_INI_DIR/conf.d/xdebug.ini

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install symfony cli
RUN curl -sS https://get.symfony.com/cli/installer | bash && mv /root/.symfony/bin/symfony /usr/local/bin/symfony

# Set working directory
WORKDIR /var/www

CMD ["symfony", "server:start"]