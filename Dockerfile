FROM php:8.3-apache

# Installation des extensions nécessaires
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl git gnupg libcurl4-openssl-dev libfreetype6-dev libicu-dev libjpeg-dev libonig-dev \
    libpng-dev libssl-dev libxml2-dev libzip-dev pkg-config unzip \
    && docker-php-ext-install intl pdo_mysql zip gd mbstring opcache \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Activation du mod rewrite d'Apache
RUN a2enmod rewrite

# Copie du fichier php.ini custom
#COPY ./docker/php.ini /usr/local/etc/php/conf.d/custom.ini

# Modification du DocumentRoot Apache (pour Symfony)
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/public|' /etc/apache2/sites-available/000-default.conf

# Copie du code dans le conteneur
COPY . /var/www

# Définir le répertoire de travail
WORKDIR /var/www

# Donne les bons droits
RUN chown -R www-data:www-data /var/www
