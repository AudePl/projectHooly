# ProjectHooly
Projet Hooly pour test technique pour Umake.
Mise en place d'une API

## Getting Started

### Prerequisites

1. Check Git is installed
2. Check PHP 8.4 is installed
3. Check composer is installed
4. Check MariaDB is installed

### Install

1. Clone this project
2. Run `composer install`
3. Modify in .env.dev this line : `DATABASE_URL="mysql://user:password@127.0.0.1:3306/nom_de_la_base"`
4. Create DataBase : `php bin/console doctrine:database:create`
5. Execute migrations : `php bin/console doctrine:migrations:migrate`
6. Run server : `php bin/console server:start`

### Working

1. Run `symfony server:start` to launch your local php web server

### URLs availables

* Homepage [localhost:8000/](localhost:8000/)
* Doc API en json [localhost:8000/api/doc.json](localhost:8000/api/doc.json)
