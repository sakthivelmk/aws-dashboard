FROM php:apache
MAINTAINER Sakthivel MK (shakthivelmk@gmail.com)
COPY index.php /var/www/html/
COPY apiRequest.php /var/www/html/
COPY aws_php_sdk/ /var/www/html/
COPY css/ /var/www/html/