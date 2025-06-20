# Green Clean

Green Clean est une application web qui connecte des donateurs à des projets écologiques innovants. Elle repose sur Symfony et propose une expérience moderne, sécurisée et responsive.

## Fonctionnalités principales

- **Parcours utilisateur complet** : navigation, inscription, connexion, dons, consultation des projets.
- **Gestion des projets** : création, modification, suppression, upload d’images (VichUploader).
- **Système de dons** : formulaire de don, historique, gestion des montants et messages personnalisés.
- **Compteur de vues** : chaque projet affiche le nombre de consultations.
- **Administration** : interface EasyAdmin pour gérer utilisateurs, projets et dons.
- **Notifications** : messages de confirmation et alertes.
- **Interface responsive** : Bootstrap 5, SCSS personnalisés, Webpack Encore.

## Pages principales

- **Accueil** (`/`) : Présentation, derniers projets, appel à l’action pour faire un don.
- **Projets** (`/projets`) : Liste de tous les projets, accès à chaque fiche projet.
- **Fiche projet** (`/projects/{id}`) : Détail du projet, image, description, compteur de vues, formulaire de don.
- **À propos** (`/about`) : Présentation de l’association.
- **Connexion** (`/login`) : Authentification utilisateur.
- **Admin** (`/admin`) : Tableau de bord, gestion CRUD des entités (projets, dons, utilisateurs).

## Architecture technique

- Symfony 7, Doctrine ORM, Twig, Webpack Encore, Bootstrap 5, EasyAdmin, VichUploader, Redis.
- Docker pour le développement local (PHP, Nginx, MySQL, Redis, phpMyAdmin).
- Tests unitaires avec PHPUnit.

## Exemple de parcours utilisateur

1. L’utilisateur visite la page d’accueil, découvre les projets récents.
2. Il consulte la liste complète des projets, puis la fiche détaillée d’un projet.
3. Il se connecte ou s’inscrit pour faire un don.
4. Il accède à son espace personnel (si implémenté) ou reçoit une confirmation de don.
5. Un administrateur gère les projets, dons et utilisateurs via l’interface d’administration.

## Dépendances principales

- **Symfony Framework**
- **Doctrine ORM**
- **Twig**
- **Webpack Encore**
- **VichUploaderBundle**
- **EasyAdminBundle**
- **Predis**
- **PHPUnit**

## Prérequis

- PHP 8.1 ou supérieur
- Composer
- Node.js et npm
- Docker (optionnel pour l'environnement de développement)

## Installation

1. Clonez le dépôt :
   ```bash
   git clone <url-du-repo>
   cd green-clean
   ```
2. Installez les dépendances PHP :
   ```bash
   composer install
   ```
3. Installez les dépendances JavaScript :
   ```bash
   npm install
   ```
4. Configurez les variables d'environnement :
   Copiez le fichier `.env` en `.env.local` et modifiez les valeurs selon vos besoins.
5. Lancez les migrations de la base de données :
   ```bash
   php bin/console doctrine:migrations:migrate
   ```
6. (Optionnel) Lancez l'environnement Docker :
   ```bash
   docker-compose up -d
   ```

## Configuration des variables d'environnement

Le fichier `.env` contient les variables d'environnement nécessaires pour configurer l'application. Exemple :
```env
APP_ENV=dev
APP_SECRET=your_secret_key
DATABASE_URL=mysql://user:password@127.0.0.1:3306/green
MESSENGER_TRANSPORT_DSN=redis://localhost:6379/messages
MAILER_DSN=smtp://localhost:1025
REDIS_URL=redis://localhost:6379
```

## Utilisation de Docker

Le projet inclut une configuration Docker pour simplifier le déploiement et le développement local. Services :
- **app** : Symfony + PHP 8.3
- **nginx** : Serveur web
- **db** : MySQL 8.0
- **phpmyadmin** : Interface MySQL (port 8081)
- **redis** : Cache et files d'attente

### Commandes Docker
- Démarrer : `docker-compose up -d`
- Arrêter : `docker-compose down`
- Recréer : `docker-compose up -d --build`
- Accéder à un conteneur : `docker exec -it symfony_app bash`

### Accès aux services
- Application : [http://localhost:8000](http://localhost:8000)
- PhpMyAdmin : [http://localhost:8081](http://localhost:8081)

## Lancement du serveur de développement

1. Compilez les assets :
   ```bash
   npm run dev
   ```
2. Lancez le serveur Symfony :
   ```bash
   symfony server:start
   ```

## Tests

Pour exécuter les tests unitaires :
```bash
php bin/phpunit
```

## Structure du projet

- **assets/** : JS, SCSS, images
- **config/** : Configuration Symfony
- **public/** : Point d'entrée public
- **src/** : Contrôleurs, entités, services
- **templates/** : Vues Twig
- **tests/** : Tests
- **translations/** : Traductions

## Entités principales

- **User** : Utilisateurs, rôles, dons
- **Projects** : Projets écologiques (titre, description, image)
- **Donations** : Dons liés à un projet et un utilisateur

## Contribution

Les contributions sont les bienvenues ! Veuillez soumettre une pull request ou ouvrir une issue pour discuter des changements.

## Licence

Ce projet est sous licence MIT. Consultez le fichier `LICENSE` pour plus d'informations.