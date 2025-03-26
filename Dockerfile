# Image de base PHP avec FPM et CLI
FROM php:8.2-fpm

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
    && echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/mongodb.ini \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN apt-get update && apt-get install -y libcurl4-openssl-dev libssl-dev \
    && if ! php -m | grep -q mongodb; then pecl install mongodb && echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/mongodb.ini; fi

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

# Droits corrects pour le stockage
RUN chown -R www-data:www-data /var/www/var \
    && chown -R www-data:www-data /var/www/public/uploads

# Exposition du port FPM
EXPOSE 9000

# Commande de démarrage
CMD ["php-fpm"]
