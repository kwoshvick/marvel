FROM php:8.1-fpm

# Copy composer.lock and composer.json
#COPY composer.lock composer.json /var/www/

# Set working directory
WORKDIR /marvel

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl


# Install nodejs
RUN curl -sL https://deb.nodesource.com/setup_16.x |  bash -
RUN apt-get -y install nodejs

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo pdo_mysql pcntl
#RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
#RUN groupadd -g 1000 www
#RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
#COPY composer.json composer.json
#COPY composer.lock composer.lock
#COPY composer.json composer.json


COPY . .
RUN cp docker/laravel/envs/env.dev ./.env
RUN npm install
RUN composer install --ignore-platform-reqs
RUN composer dump-autoload

#RUN php artisan key:generate
#RUN php artisan jwt:secret
RUN chmod 777 -R storage


#COPY . .
#RUN composer install

# Copy existing application directory permissions
#COPY --chown=www:www . /var/www

# Change current user to www
#USER www

#RUN php artisan passport:key


# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
