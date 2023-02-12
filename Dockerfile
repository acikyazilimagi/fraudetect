FROM php:7.4-apache

# Copy the rest of the application files into the image
COPY . /var/www/html/

# Enable necessary Apache modules
RUN a2enmod rewrite
RUN a2enmod headers
RUN a2enmod dir
RUN apt-get update 
RUN apt-get install -y  zlib1g-dev \
                        libpq-dev \
                        git \
                        libicu-dev \
                        libxml2-dev \
                        libcurl4-openssl-dev \
                        pkg-config \
                        libssl-dev \
                        libzip-dev \
                        libfreetype6-dev \
                        libjpeg62-turbo-dev \
                        libpng-dev \
                        curl \
                        net-tools \
                        php7.4-sqlite3 \
                        iputils-ping \
                        vim \
                        nano
                        
# Install the MySQL and cURL extensions
RUN docker-php-ext-install mysqli curl 

# Enable the MySQL extension
RUN docker-php-ext-enable mysqli

# Restart Apache
RUN /etc/init.d/apache2 restart