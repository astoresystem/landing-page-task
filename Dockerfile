FROM php:8.1-apache



RUN apt-get update && apt-get upgrade -y
RUN a2enmod ssl rewrite setenvif
COPY localhost-selfsigned-dev.crt /etc/ssl/certs/localhost-selfsigned-dev.crt
COPY localhost-selfsigned-dev.key /etc/ssl/private/localhost-selfsigned-dev.key
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

RUN mkdir /var/www/html/files
RUN chown -R www-data:www-data /var/www/html/files
RUN chmod -R 775 /var/www/html/files

CMD ["apache2-foreground"]