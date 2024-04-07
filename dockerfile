FROM php:8.2-apache

# Установите необходимые PHP расширения
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip


# Включите mod_rewrite для Apache
RUN a2enmod rewrite

# Конфигурация Apache для разрешения доступа к директории
RUN echo '<Directory "/var/www/html">' > /etc/apache2/conf-available/symfony.conf \
    && echo '    Options Indexes FollowSymLinks' >> /etc/apache2/conf-available/symfony.conf \
    && echo '    AllowOverride All' >> /etc/apache2/conf-available/symfony.conf \
    && echo '    Require all granted' >> /etc/apache2/conf-available/symfony.conf \
    && echo '</Directory>' >> /etc/apache2/conf-available/symfony.conf \
    && a2enconf symfony

# Указание Apache использовать публичную директорию Symfony как DocumentRoot
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Установите Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Копируйте исходный код в контейнер
COPY . /var/www/html

# Установка прав доступа
# RUN chown -R www-data:www-data /var/www/html/var/log
# RUN chmod -R 775 /var/www/html/var/log

WORKDIR /var/www/html

RUN composer install \
    && php bin/console make:migration \
    && php bin/console make:migrations:migrate --no-interaction