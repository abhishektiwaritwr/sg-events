FROM php:8.1-apache

# Install system deps and PHP extensions
RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y \
    git unzip libzip-dev zip \
  && docker-php-ext-install pdo pdo_mysql mbstring zip \
  && rm -rf /var/lib/apt/lists/*

# copy composer binary from composer image (optional)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy entire project (we rely on vendor/ being committed in repo)
COPY . .

# Ensure permissions
RUN a2enmod rewrite || true
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

EXPOSE 80
CMD ["apache2-foreground"]
