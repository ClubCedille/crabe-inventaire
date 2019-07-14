# Crabe Inventaire

Ce projet est une collaboration du Club Cedille et du regroupement étudiant Crabe de l'ÉTS.

## Context

Le CRABE est une CO-OP agissant a titre d'atelier de réparation de vélo. Il est possible d'en devenir
membre pour avoir acces au local et profiter des outils qui y sont disponibles.

Il est aussi possible d'acheter certaines pièces lorsqu'elles sont nécessaires à la réparation d'un vélo.

Cet inventaire est mis à disposition des membres du CRABE et ils peuvent acheter les pièces
nécessaires selon un prix suggéré, mais ils peuvent donner ce qu'ils veulent. La caisse est actuellement
une boite, et la COOP est confiance aux utilisateurs pour qu'ils laissent l'argent dans cette boite et notent
eux-mêmes les pièces qu'ils ont prises, afin d'avoir un suivi sur l'état de l'inventaire.

Par contre, la balance n'est pas toujours bonne: l'inventaire manque certaines pièces, parfois l'argent dans
la boite ne concorde pas avec ce qui est écrit dans le registre, bref, il y a des vols.

Ce système vient remplacer la boite/calepins par un site web qui permet de conserver des traces de l'inventaire, faire un suivi des stocks, de l'argent, des membres actifs de la COOP en plus d'éviter
les villes (surtout au niveau l'argent qui était dans la boite, sans surveillance)

## Configuration de l'env de travail

- Installer `virtualbox`

- Installer `vagrant` 

- Installer `composer` (un package manager pour PHP), PHP7.2 et PHP7.2-xml

- Installer laravel avec la commande `composer global require laravel/installer`

- Dans le repertoire du projet, lancer `composer require laravel/homestead --dev` pour installer `Homestead`

    - Ensuite cette commande pour la config de Homestead `php vendor/bin/homestead make`

    - Ajouter cette ligne `192.168.10.10  homestead.test` dans le fichier `/etc/hosts` si vous changez le hosname dans ce fichier, il faut le faire aussi dans le fichier de config de Homestead  `Homestead.yaml`

- Lancez `vagrant up`, une base de donnee est deja configure et les changements se font en direct .

- Voila, l'application est accessible depuis _homestead.test_ dans ton navigateur.

Pour plus d'information sur la configuration, regardez [ce lien](https://laravel.com/docs/5.8/homestead) et [celui-ci](https://laravel.com/docs/5.8)

Si un package manque dans la vm, vous pouvez y aller avec `vagrant ssh` (pass: `vagrant`) et installez le manuellment avec `apt install`
    - comme `apt-get install ifupdown` si `/sbin/ifdown: No such file or directory`




## Choix technologiques

### Backend : Laravel 

Ce framework web est une bonne porte d'entrée dans le développement web pour les programmeurs de tout niveau

### Front-end : Blade, VueJs


## Licence 

GNU GENERAL PUBLIC LICENSE
Version 3, 29 June 2007

Copyright (C) 2007 Free Software Foundation, Inc. <https://fsf.org/>
Everyone is permitted to copy and distribute verbatim copies
of this license document, but changing it is not allowed.
