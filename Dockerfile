# Image de base PHP avec FPM et CLI
FROM php:8.3-fpm

# Installation des dépendances minimales
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        intl \
        pdo_mysql \
        zip \
        opcache \
        curl \
        mbstring \
        gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configuration de Composer pour forcer HTTPS
RUN composer config --global secure-http true && composer self-update

# Installation de Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

# Définition du répertoire de travail
WORKDIR /var/www

# Copie du projet Symfony
COPY . /var/www
COPY php/docker-php.ini /usr/local/etc/php/conf.d/zz-docker-php.ini

# Droits corrects pour le stockage
RUN chown -R www-data:www-data /var/www/var \
    && chown -R www-data:www-data /var/www/public/uploads

# Exposition du port FPM
EXPOSE 9000

# Commande de démarrage
CMD ["php-fpm"]
