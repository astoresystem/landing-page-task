FROM php:8.1-apache





USER www-data:www-data
WORKDIR /var/www/html


RUN mkdir /var/www/html/files
RUN chown -R www-data:www-data /var/www/html/files
RUN chmod -R 775 /var/www/html/files