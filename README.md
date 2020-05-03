# Crabe Inventaire

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/8198dc3af1cd4e4fb2aece7957b760dd)](https://app.codacy.com/gh/ClubCedille/crabe-inventaire?utm_source=github.com&utm_medium=referral&utm_content=ClubCedille/crabe-inventaire&utm_campaign=Badge_Grade_Dashboard)

Ce projet est le résultat d'une collaboration entre le club CEDILLE et le regroupement étudiant CRABE de l'ÉTS.

## Context

Le CRABE est une coopérative agissant à titre d'atelier de réparation de vélos. Il est possible d'en devenir
membre pour obtenir l'accès au local de réparation et profiter des outils qui y sont disponibles.

Il est aussi possible d'acheter certaines pièces lorsqu'elles sont nécessaires à la réparation d'un vélo.

Cet inventaire est mis à disposition des membres du CRABE et ils peuvent acheter les pièces
nécessaires selon un prix suggéré, mais ils peuvent aussi donner ce qu'ils veulent. La caisse est actuellement
une boite. La coopérative fait confiance aux utilisateurs pour qu'ils laissent l'argent dans cette boite et notent
eux-mêmes les pièces qu'ils ont prises, afin d'avoir un suivi sur l'état de l'inventaire.

Par contre, la balance n'est pas toujours exacte: certaines pièces manquent à l'inventaire et parfois l'argent dans
la boite ne concorde pas avec ce qui est écrit dans le registre, bref, il y a des vols.

Ce système vient remplacer la boite et le calepin par un site web qui permet de conserver des traces de l'inventaire, faire un suivi des stocks, de l'argent, des membres actifs de la coopérative en plus d'éviter
les vols. On évitera surtout les vols au niveau de l'argent qui est laissé dans la boite sans surveillance.

## Configuration de l'env de travail

- Installer `virtualbox`

- Installer `vagrant`

- Installer `composer` (un package manager pour PHP), PHP7.2 et PHP7.2-xml

- Installer laravel avec la commande `composer global require laravel/installer`

- Dans le repertoire du projet, lancer `composer require laravel/homestead --dev` pour installer `Homestead`

  - Ensuite cette commande pour la config de Homestead `php vendor/bin/homestead make`

  - Ajouter cette ligne `192.168.10.10 homestead.test` dans le fichier `/etc/hosts` si vous changez le hostname dans ce fichier, il faut le faire aussi dans le fichier de config de Homestead `Homestead.yaml`

- Renomer le fichier `.env.example` en `.env`

- Modifier le fichier `.env` avec les bonnes valeurs pour `PAYPAL_CLIENT_ID` et `PAYPAL_SECRET`, on récupère ces valeurs en connectant un compte [PayPal Developer](https://developer.paypal.com/) et créant une nouvelle app (il faut avoir un compte PayPal).

- Modifier le fichier `.env` avec les bonnes valeurs pour `MAIL_USERNAME` et `MAIL_PASSWORD`, pour cela il faut créer un compte [mailtrap](https://mailtrap.io/), récupérer votre username et mot de pass et les ajouter au fichier `.env`.

- Lancez `vagrant up`, une base de données est déjà configurée et les changements se font en direct.

- Voilà, l'application est accessible depuis _homestead.test_ dans votre navigateur.

Pour plus d'information sur la configuration, regardez [ce lien](https://laravel.com/docs/5.8/homestead) et [celui-ci](https://laravel.com/docs/5.8)

Si un package manque dans la VM, vous pouvez y aller avec `vagrant ssh` (pass: `vagrant`) et l'installer manuellment avec `apt install` - comme `apt-get install ifupdown` si `/sbin/ifdown: No such file or directory`

## Commandes, trucs & astuces

#### Nettoyer la cache (doit être fait après la modification des fichiers de langues)

- php artisan cache:clear

## Choix technologiques

### Backend : Laravel

Ce framework web est une bonne porte d'entrée vers le développement web pour les programmeurs de tout niveau.

### Front-end : Blade, VueJs

### Contributions

Si vous voulez contribuer au projet, assurez-vous de fournir ou de mettre à jour les tests pour vos modifications.

Il est possible d'exécuter la suite de tests à l'aide de la commande

```bash
./vendor/bin/phpunit
```

## Licence

GNU GENERAL PUBLIC LICENSE
Version 3, 29 June 2007

Copyright (C) 2007 Free Software Foundation, Inc. <https://fsf.org/>
Everyone is permitted to copy and distribute verbatim copies
of this license document, but changing it is not allowed.
