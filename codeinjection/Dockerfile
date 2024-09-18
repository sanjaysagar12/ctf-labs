# Use the official PHP image with Apache
FROM php:8.1-apache

RUN apt update
RUN apt-get install iputils-ping -y
# Copy the current directory (where ping.php is) into the container's web directory
COPY . /var/www/html/

# Expose port 80 for the web server
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
