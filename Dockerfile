# Image de base PHP avec FPM et CLI
FROM php:8.4.5-fpm

# Installation des certificats SSL avant les extensions pour éviter les erreurs de mise à jour
RUN apt-get update && apt-get install -y ca-certificates

# Installation des dépendances système et extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    curl \
    git \
    libcurl4-openssl-dev \
    libicu-dev \
    libonig-dev \
    libssl-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install intl pdo_mysql zip opcache curl mbstring \
    && docker-php-ext-enable opcache curl mbstring \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/mongodb.ini \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Configuration de curl pour utiliser les certificats SSL
RUN update-ca-certificates

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configuration de Composer pour forcer HTTPS
RUN composer config --global secure-http true && composer self-update

# Installation de Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Définition du répertoire de travail
WORKDIR /var/www

# Copie du projet Symfony
COPY . /var/www

# Droits corrects pour le stockage
RUN chown -R www-data:www-data /var/www/var \
    && chown -R www-data:www-data /var/www/public/uploads

# Exposition du port FPM
EXPOSE 9000

# Commande de démarrage
CMD ["php-fpm"]
