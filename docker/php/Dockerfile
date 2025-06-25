FROM ubuntu:24.04

# Установка основных пакетов и добавление PPA для PHP
RUN apt-get update && apt-get install -y \
    software-properties-common \
    && add-apt-repository ppa:ondrej/php -y \
    && apt-get update

# Установка PHP 8.3 и необходимых расширений
RUN apt-get install -y \
    php8.3-fpm \
    php8.3-cli \
    php8.3-dev \
    php8.3-gd \
    php8.3-mysql \
    php8.3-mbstring \
    php8.3-xml \
    php8.3-zip \
    php8.3-bcmath \
    php8.3-exif \
    php8.3-redis \
    php8.3-intl \
    php8.3-pdo \
    php8.3-http \
    php8.3-raphf \
    php8.3-curl \
    libfreetype6-dev \
    libjpeg-dev \
    libpng-dev \
    libzip-dev \
    libxml2-dev \
    libonig-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    zip \
    unzip

RUN apt-get install -y git

RUN apt-get install -y nginx


RUN apt-get install -y supervisor

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Установка зависимостей через Composer
WORKDIR /var/www

# Копирование пользовательской конфигурации PHP
COPY ./docker/php/local.ini /usr/local/etc/php/conf.d/local.ini
# Копирование конфигурации Nginx
COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf

# Копирование конфигурации Supervisor
COPY ./docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY ./docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Запуск Nginx и PHP-FPM
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD service php8.3-fpm start && nginx -g 'daemon off;'
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
