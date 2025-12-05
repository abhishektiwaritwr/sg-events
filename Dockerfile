FROM php:8.1-apache

# Install system deps and PHP extensions
RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y \
    git unzip libzip-dev zip \
  && docker-php-ext-install pdo pdo_mysql mbstring zip \
  && rm -rf /var/lib/apt/lists/*

# Composer (copy from official image)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files and install dependencies (if present)
COPY composer.json composer.lock ./
RUN if [ -f composer.json ]; then composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader || true; fi

# Copy application code
COPY . .

# Enable rewrite for Laravel and set permissions
RUN a2enmod rewrite || true
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

EXPOSE 80
CMD ["apache2-foreground"]
