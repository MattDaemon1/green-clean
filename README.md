# Green Clean

Green Clean est une application web conçue pour faciliter la gestion des projets écologiques. Elle repose sur le framework Symfony et utilise des technologies modernes pour offrir une expérience utilisateur optimale.

## Fonctionnalités principales

- **Gestion des utilisateurs** : Inscription, connexion et gestion des rôles.
- **Gestion des projets** : Création, modification et suppression de projets.
- **Téléchargement de fichiers** : Support pour l'upload et la gestion des fichiers.
- **Notifications** : Système de notifications pour les utilisateurs.
- **Interface utilisateur moderne** : Construite avec Webpack Encore et SCSS.

## Dépendances principales

Le projet utilise les dépendances suivantes :

- **Symfony Framework** : Framework PHP pour le développement web.
- **Doctrine ORM** : Gestion des bases de données relationnelles.
- **Twig** : Moteur de templates pour le rendu des vues.
- **Webpack Encore** : Gestionnaire d'assets modernes pour JavaScript et CSS.
- **VichUploaderBundle** : Gestion des téléchargements de fichiers.
- **EasyAdminBundle** : Interface d'administration pour gérer les entités.
- **Predis** : Client Redis pour PHP.
- **PHPUnit** : Framework de tests unitaires pour PHP.

## Prérequis

- PHP 8.1 ou supérieur
- Composer
- Node.js et npm
- Docker (optionnel pour l'environnement de développement)

## Installation

1. Clonez le dépôt :
   
   git clone <url-du-repo>
   cd green-clean
   

2. Installez les dépendances PHP :
   
   composer install
   

3. Installez les dépendances JavaScript :
   
   npm install
   

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

Le fichier `.env` contient les variables d'environnement nécessaires pour configurer l'application. Voici les principales variables :

- **APP_ENV** : Définit l'environnement d'exécution (`dev`, `prod`, `test`).
- **APP_SECRET** : Clé secrète utilisée par Symfony pour des opérations cryptographiques.
- **DATABASE_URL** : URL de connexion à la base de données (exemple : `mysql://root:root@db:3306/green?serverVersion=8.2&charset=utf8mb4`).
- **MESSENGER_TRANSPORT_DSN** : Configuration pour le transport des messages (exemple : `doctrine://default?auto_setup=0`).
- **MAILER_DSN** : Configuration pour l'envoi des emails (exemple : `smtp://localhost:1025`).
- **REDIS_URL** : URL de connexion au serveur Redis (exemple : `redis://localhost:6379`).

### Exemple de configuration

Voici un exemple de fichier `.env.local` :
```env
APP_ENV=dev
APP_SECRET=your_secret_key
DATABASE_URL=mysql://user:password@127.0.0.1:3306/green
MESSENGER_TRANSPORT_DSN=redis://localhost:6379/messages
MAILER_DSN=smtp://localhost:1025
REDIS_URL=redis://localhost:6379
```

## Utilisation de Docker

Le projet inclut une configuration Docker pour simplifier le déploiement et le développement local. Voici les services configurés dans le fichier `docker-compose.yml` :

- **app** : Conteneur principal exécutant l'application Symfony avec PHP 8.3 et les extensions nécessaires.
- **nginx** : Serveur web Nginx configuré pour servir l'application.
- **db** : Base de données MySQL 8.0 avec un utilisateur et une base de données dédiés.
- **phpmyadmin** : Interface graphique pour gérer la base de données MySQL, accessible sur le port 8081.
- **redis** : Serveur Redis utilisé pour la mise en cache et les files d'attente.

### Commandes Docker

1. **Démarrer les conteneurs** :
   ```bash
   docker-compose up -d
   ```

2. **Arrêter les conteneurs** :
   ```bash
   docker-compose down
   ```

3. **Recréer les conteneurs (si nécessaire)** :
   ```bash
   docker-compose up -d --build
   ```

4. **Accéder à un conteneur** :
   ```bash
   docker exec -it symfony_app bash
   ```

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

Accédez à l'application via [http://localhost:8000](http://localhost:8000).

## Tests

Pour exécuter les tests unitaires :
```bash
php bin/phpunit
```

## Structure du projet

- **assets/** : Contient les fichiers JavaScript, SCSS et images.
- **config/** : Fichiers de configuration de Symfony.
- **public/** : Point d'entrée public de l'application.
- **src/** : Contient le code source de l'application (contrôleurs, entités, services, etc.).
- **templates/** : Fichiers Twig pour le rendu des vues.
- **tests/** : Tests unitaires et fonctionnels.
- **translations/** : Fichiers de traduction.

## Entités principales

- **User** : Représente les utilisateurs de l'application avec des rôles, des identifiants uniques et des relations avec les dons.
- **Projects** : Gère les projets écologiques, incluant des informations comme le titre, la description et les images associées.
- **Donations** : Permet de suivre les dons effectués par les utilisateurs pour des projets spécifiques.

Ces entités sont définies dans le dossier `src/Entity` et utilisent Doctrine ORM pour la gestion des relations et des bases de données.

## Contribution

Les contributions sont les bienvenues ! Veuillez soumettre une pull request ou ouvrir une issue pour discuter des changements que vous souhaitez apporter.

## Licence

Ce projet est sous licence MIT. Consultez le fichier `LICENSE` pour plus d'informations.