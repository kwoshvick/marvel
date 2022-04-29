FROM php:8.1-fpm

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


COPY . .
RUN cp docker/laravel/envs/env.dev ./.env
RUN npm install
RUN composer install --ignore-platform-reqs
RUN composer dump-autoload

RUN chmod 777 -R storage

EXPOSE 9000
CMD ["php-fpm"]
