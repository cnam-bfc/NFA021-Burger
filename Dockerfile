# PHP docker container
FROM php:8.3.4-apache

# Install PDO MySQL driver (optional)
RUN docker-php-ext-install pdo_mysql

# Enable mod rewrite (optional)
RUN a2enmod rewrite

# Use the default production configuration
#RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Set Apache document root
ENV APACHE_DOCUMENT_ROOT=/app/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Application port (optional)
EXPOSE 80

# Container start command
CMD ["apache2-foreground"]

# Create application directory
RUN mkdir /app

# Add data application directory
RUN mkdir /app/data

# Add public files to application directory
COPY public /app/public

# Add source code files to application directory
COPY src /app/src

# Ensure file ownership for application files
RUN chown -R www-data:www-data /app