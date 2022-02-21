FROM devilbox/php-fpm-8.1
RUN apt-get update  
RUN apt -yqq update
RUN apt -yqq install libxml2-dev
RUN apt-get install -y   git 
RUN apt-get install -y   curl 
RUN apt-get install -y   libpng-dev 
RUN apt-get install -y   libonig-dev 
RUN apt-get install -y   libxml2-dev 
RUN apt-get install -y   libzip-dev  
RUN apt-get install -y   zip 
RUN apt-get install -y   unzip 
# RUN apt-get install -y   gd
RUN docker-php-ext-install gd
RUN docker-php-ext-install zip 
RUN docker-php-ext-install mysqli  
RUN docker-php-ext-install pdo_mysql
#RUN docker-php-ext-install pdo  

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer