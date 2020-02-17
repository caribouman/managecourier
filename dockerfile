#start with our base image (the foundation) - version 7.1.5
FROM php:7.2-apache

#install all the system dependencies and enable PHP modules 
RUN apt-get update && apt-get install -y libicu-dev libpq-dev libmcrypt-dev git zip unzip nano mariadb-client
RUN rm -r /var/lib/apt/lists/*
RUN docker-php-ext-install intl
RUN docker-php-ext-install mbstring 
RUN docker-php-ext-install pcntl 
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install opcache
#install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

#set our application folder as an environment variable
ENV APP_HOME /var/www/html

#change uid and gid of apache to docker user uid/gid
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

#change the web_root to cakephp /var/www/html/webroot folder
RUN sed -i -e "s/html/html\/webroot/g" /etc/apache2/sites-enabled/000-default.conf

# enable apache module rewrite
RUN a2enmod rewrite

#copy source files and run composer
COPY . $APP_HOME 

# install all PHP dependencies
RUN composer update --no-interaction

RUN composer install --no-interaction

#change ownership of our applications
RUN chown -R 1000:1000 $APP_HOME

