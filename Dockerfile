# Dockerfile for Laravel Application
# Use the official PHP image with Apache
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update \
    && apt-get install -y \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        zip \
        unzip \
        git \
        curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy composer and install dependencies
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer
COPY . /var/www/html

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Expose port 80
EXPOSE 80

# Copy Apache vhost config
COPY ./docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Copy and set entrypoint
COPY ./docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Start via entrypoint (runs migrate --seed, then Apache)
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
