FROM php:8.2-fpm

# Устанавливаем необходимые пакеты
RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libicu-dev \
        libxml2-dev \
        libzip-dev

# Устанавливаем PHP-расширения, включая MySQL
RUN docker-php-ext-install -j$(nproc) intl bcmath soap mysqli pdo_mysql zip \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Добавляем кастомные настройки PHP
ADD php.ini /usr/local/etc/php/conf.d/40-custom.ini

# Настраиваем рабочую директорию
WORKDIR /app

# Команда для запуска PHP-FPM
CMD ["php-fpm"]


