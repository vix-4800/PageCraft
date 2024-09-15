FROM php:8.2-fpm

LABEL Anton Vix <https://github.com/vix-4800>

SHELL ["/bin/bash", "--login", "-c"]

# Update and install dependencies
RUN apt update \
    && apt install -y openssl zip unzip libzip-dev libicu-dev postgresql-client libpq-dev

# Configure and install PHP extensions
RUN docker-php-ext-configure intl \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip intl

# Install xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Cleanup
RUN apt clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

EXPOSE 9000
EXPOSE 9003
CMD ["php-fpm"]
