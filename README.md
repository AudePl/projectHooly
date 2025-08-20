# ProjectHooly
Projet Hooly pour test technique pour Umake.
Mise en place d'une API sous Symfony7.2 / PHP8.4 en suivant les principes d'une architecture REST.

## Getting Started

### Prerequisites

1. Check Git is installed
2. Check PHP 8.4 (and classics extensions packages) is installed
3. Check composer is installed
4. Check MariaDB is installed
5. Check Symfony-CLI is installed and bashrc updated

### Install

1. Clone this project
2.Go to the new folder with : `cd projectHooly`
3. Run `composer install`
4. Modify in .env this line : `DATABASE_URL="mysql://user:password@127.0.0.1:3306/nom_de_la_base"`
5. Create DataBase : `php bin/console doctrine:database:create`
6. Execute migrations : `php bin/console doctrine:migrations:migrate`

### Working

1. Run `symfony server:start` to launch your local php web server

### URLs availables

* Homepage par défaut [localhost:8000/](localhost:8000/)
* Doc API en json [localhost:8000/api/doc.json](localhost:8000/api/doc.json)


========================================================================================================================================

Axes d'améliorations à mettre en place : 
- Mise en place d'une authentification via JWT
- Création d'exceptions techniques et fonctionnelles via un service
- Création d'un champ "actif" pour les emplacements/créneaux pour gestion historique des réservations
- Création d'autres endPoint

Pour information : 
Estimation du temps de réalisation = 30h (dont 5h d'initialisation de l'environnement de développement)

