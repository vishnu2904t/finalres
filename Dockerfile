# Use the official PHP-Apache image
FROM php:8.1-apache

# Enable required PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Set the working directory in the container
WORKDIR /var/www/html

# Copy the project files (including PHPMailer) into the container
COPY . /var/www/html

# Give Apache necessary permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 80 for Apache
EXPOSE 80

# Start Apache when the container runs
CMD ["apache2-foreground"]
