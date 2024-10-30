FROM php:8.2-fpm

RUN apt update && apt install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libxslt-dev \
    libicu-dev \
    libmcrypt-dev \
    libpng-dev \
    libxml2-dev \
    git \
    libzip-dev \
    libonig-dev \
	&& docker-php-ext-install -j$(nproc) exif iconv mbstring mysqli pdo_mysql zip \
    && apt-get autoclean -y \
    	&& rm -rf /var/lib/apt/lists/* \
    	&& rm -rf /tmp/pear/

COPY --from=composer:2.6.6 /usr/bin/composer /usr/bin/

RUN curl -sL https://deb.nodesource.com/setup_22.x | bash - && apt-get install -y nodejs

WORKDIR /opt/buckbeak

#RUN composer i --no-dev -o \
#    && php artisan migrate --seed \
#    && php artisan optimize -q





