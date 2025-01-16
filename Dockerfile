# Base image for PHP with Composer
FROM php:8.1-fpm

# Install required system dependencies
RUN apt-get update && apt-get install -y nginx unzip git

# Copy application code to the container
WORKDIR /app
COPY . .

# Install Composer dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# Copy Nginx configuration
COPY nginx.conf /etc/nginx/nginx.conf

# Expose application port
EXPOSE 80

# Start Nginx and PHP-FPM
CMD service nginx start && php-fpm
