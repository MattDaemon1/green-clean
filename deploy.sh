#!/bin/bash

# Configuration du serveur
SERVER_USER="your_server_user"
SERVER_IP="your_server_ip"
DEPLOY_DIR="/var/www/green-clean"

# Création du dossier de déploiement
ssh ${SERVER_USER}@${SERVER_IP} "mkdir -p ${DEPLOY_DIR}"

# Copie des fichiers
scp -r . ${SERVER_USER}@${SERVER_IP}:${DEPLOY_DIR}

# Connexion au serveur
ssh ${SERVER_USER}@${SERVER_IP} "cd ${DEPLOY_DIR} && \
    # Arrêt des services existants
    docker-compose -f docker-compose.prod.yml down && \
    # Construction des images
    docker-compose -f docker-compose.prod.yml build && \
    # Lancement des services
    docker-compose -f docker-compose.prod.yml up -d && \
    # Installation des dépendances
    docker-compose -f docker-compose.prod.yml exec app composer install --no-dev --optimize-autoloader && \
    # Compilation des assets
    docker-compose -f docker-compose.prod.yml exec app npm install && \
    docker-compose -f docker-compose.prod.yml exec app npm run build && \
    # Mise à jour du schéma de la base de données
    docker-compose -f docker-compose.prod.yml exec app php bin/console doctrine:schema:update --force && \
    # Clear cache
    docker-compose -f docker-compose.prod.yml exec app php bin/console cache:clear --no-warmup && \
    docker-compose -f docker-compose.prod.yml exec app php bin/console cache:warmup"
