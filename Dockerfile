# Use an official PHP runtime as a parent image
FROM php:7.4-apache

# Set the working directory
WORKDIR /var/www/html

# Copy the current directory contents into the container at /var/www/html
COPY . /var/www/html

# Install PHP extensions and dependencies
RUN docker-php-ext-install mysqli

# Enable Apache mod_rewrite (if you need URL rewrites)
RUN a2enmod rewrite

# Copy the .env file into the container
COPY .env /var/www/html/.env

# Make port 80 available to the world outside this container
EXPOSE 80
