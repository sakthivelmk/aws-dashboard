FROM php:apache
MAINTAINER Sakthivel MK (shakthivelmk@gmail.com)
COPY index.php /var/www/html/
COPY apiRequest.php /var/www/html/
COPY aws_php_sdk/ /var/www/html/aws_php_sdk/
COPY css/ /var/www/html/css/

ARG buildtime_variable_1=default_value_1
ENV AWS_ACCESS_KEY_ID=$buildtime_variable_1

ARG buildtime_variable_2=default_value_2
ENV AWS_SECRET_ACCESS_KEY=$buildtime_variable_2