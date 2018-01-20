FROM wordpress
MAINTAINER Bobby Ratliff

RUN a2enmod include

COPY .htaccess /var/www/html