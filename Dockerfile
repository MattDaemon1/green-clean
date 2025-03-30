# Image de base PHP avec FPM et CLI
FROM php:8.4.5-fpm

# Installation des dépendances système et des extensions PHP
RUN apt-get update && apt-get install -y \
    ca-certificates \
    curl \
    git \
    libcurl4-openssl-dev \
    libicu-dev \
    libonig-dev \
    libsodium-dev \
    libssl-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install curl intl mbstring opcache pdo_mysql sodium zip \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Configuration de curl pour utiliser les certificats SSL
RUN update-ca-certificates

# Installation de Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# Configuration de Composer pour forcer HTTPS
RUN composer config --global secure-http true && composer self-update

# Installation de Symfony CLI (téléchargement direct du binaire)
RUN curl -sSLo /usr/local/bin/symfony https://github.com/symfony/cli/releases/latest/download/symfony_linux_amd64 \
    && chmod +x /usr/local/bin/symfony

# Définition du répertoire de travail
WORKDIR /var/www

# Copie du projet Symfony
COPY . /var/www

# Installation des dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Vérification des exigences Symfony
RUN symfony check:requirements --ansi

# Vérification de la sécurité Symfony (ignorer les erreurs)
RUN symfony check:security --ansi || true

# Nettoyage du cache Symfony
RUN symfony console cache:clear --no-warmup

# Mise à jour du schéma Doctrine
RUN symfony console doctrine:schema:update --force

# Configuration de la timezone
RUN ln -snf /usr/share/zoneinfo/Europe/Paris /etc/localtime \
    && echo 'Europe/Paris' > /etc/timezone

# Définir les permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www

# Droits corrects pour le stockage
RUN chown -R www-data:www-data /var/www/var \
    && chown -R www-data:www-data /var/www/public/uploads

# Exposition du port FPM
EXPOSE 9000

# Commande de démarrage
CMD ["php-fpm"]
