FROM php:8.2-cli

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    && rm -rf /var/lib/apt/lists/*

# Install PHPMailer using Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

# Create a project directory
RUN mkdir -p /var/www/html/project
WORKDIR /var/www/html/project

# Install PHPMailer
RUN composer require phpmailer/phpmailer

# Expose port (if using a web server like Apache or Nginx, modify accordingly)
EXPOSE 9000

CMD ["php", "-a"]
