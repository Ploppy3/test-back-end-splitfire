# Test-back-end-Splitfire

[Objectifs](https://gist.github.com/helitik/8e198adf0f7c82b067af89132a29a7ff)

## Setup

### PHP

Vous pouvez directement copier le dossier `api` à la racine de votre serveur PHP.

NB: L'utilisation de Composer n'a pas été nécessaire car tout est fait maison ! Je sais cependant utiliser Composer.

### Database

Sur le serveur MySQL de votre choix:

* Créer la base de données ayant pour nom 'twitter'

  Soit simplement depuis PhpMyAdmin, soit depuis une commande SQL:

  `CREATE DATABASE twitter CHARACTER SET utf8 COLLATE utf8_general_ci;`

* Importer le Dump SQL (disponible à la racine du projet) dans la base de données.

* Connecter l'API à la base de données

  Dans le fichier `api`, ouvrir le fichier `dbConnect.php` et modifier les variables `$host, $username, $password` afin qu'elles correspondent à votre serveur MySQL.

## Utilisation

Démarrer le serveur PHP et le serveur MySQL.

En considérant que le serveur php est accessible à l'adresse `http://127.0.0.1:80/` ou plus simplement `localhost`.

Les 2 endpoints sont les suivants:

* `[POST] http://localhost/api/v1/tweets`

  En ajoutant un body de type `application/json` à la requête:
  
  `{ "author": "Claire", "message": "lorem ipsum", "hashtags": ["latin"] }`

  Le paramètre `hashtags` est facultatif.

* `[GET] http://localhost/api/v1/tweets?page=1&count=25&author=Claire&hashtag=fleurs`

  Paramètres:

  * page: number (default: 1)
  * counter: number (default: 25)
  * author?: string
  * hashtag?: string

## Code pertinent

Le code PHP & MySQL des endpoints est disponible dans le fichier `api/v1/controllers/tweets.controller.php`

## Architecture du projet

Les Controllers sont le coeur du projet, ils sont directement connectés à la base de données et sont munis de 4 fonctions (get, post, put, delete);

Un router fait la liaison entre un URL et un Controller, il transfère la requête au Controller en appelant la fonction correspondante.

```
$router = new Router();
$router->addRoute('/tweets/', new TweetsController($db));
$router->run();
```