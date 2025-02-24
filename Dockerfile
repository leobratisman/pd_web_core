# Используем официальный образ PHP с Apache
FROM php:8.2-apache

# Устанавливаем рабочую директорию
WORKDIR /var/www/html

# Устанавливаем зависимости для PHP и Laravel
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install zip pdo pdo_pgsql

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Копируем исходный код Laravel из /project в контейнер
COPY . /var/www/html

# Устанавливаем зависимости Laravel
RUN composer install --no-dev --optimize-autoloader
RUN composer require league/flysystem-aws-s3-v3 "^3.0" --with-all-dependencies

# Настраиваем права на запись для Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

RUN ls -la /var/www/html

# Копируем конфигурацию Apache из /docker/apache.conf
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Включаем модуль rewrite для Apache
RUN a2enmod rewrite

# Открываем порт 8000
EXPOSE 8000

# Запускаем Apache
CMD ["apache2-foreground"]
