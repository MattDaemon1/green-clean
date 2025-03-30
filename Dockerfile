# Utilisation de l'image officielle PHP-FPM 8.4.5
FROM php:8.4.5-fpm

# Installation des dépendances système
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    libonig-dev \
    libpq-dev \
    libxml2-dev \
    libxslt-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libcurl4-openssl-dev \
    libssl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        intl \
        zip \
        pdo_mysql \
        mbstring \
        exif \
        sockets \
        opcache \
        xsl \
    && pecl install mongodb redis \
    && docker-php-ext-enable mongodb redis \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installation de Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

# Création du répertoire de travail
WORKDIR /var/www

# Copie des fichiers du projet
COPY . /var/www

# Ajustement des permissions
RUN chown -R www-data:www-data /var/www/var \
    && chown -R www-data:www-data /var/www/public/uploads

# Copier le fichier php.ini personnalisé
COPY php/php.ini /usr/local/etc/php/php.ini

# Exposition du port PHP-FPM
EXPOSE 9000

# Commande de démarrage
CMD ["php-fpm"]
