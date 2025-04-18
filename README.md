# Green Clean

Green Clean est une application web conçue pour faciliter la gestion des projets écologiques. Elle repose sur le framework Symfony et utilise des technologies modernes pour offrir une expérience utilisateur optimale.

## Fonctionnalités principales

- **Gestion des utilisateurs** : Inscription, connexion et gestion des rôles.
- **Gestion des projets** : Création, modification et suppression de projets.
- **Téléchargement de fichiers** : Support pour l'upload et la gestion des fichiers.
- **Notifications** : Système de notifications pour les utilisateurs.
- **Interface utilisateur moderne** : Construite avec Webpack Encore et SCSS.

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

## Contribution

Les contributions sont les bienvenues ! Veuillez soumettre une pull request ou ouvrir une issue pour discuter des changements que vous souhaitez apporter.

## Licence

Ce projet est sous licence MIT. Consultez le fichier `LICENSE` pour plus d'informations.