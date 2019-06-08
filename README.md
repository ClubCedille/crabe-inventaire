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

## Usage

### Dévelopement

Lors du développement, c'est simple. Il faut s'asurer d'avoir installer docker et docker-compose.

Par la suite, il faut simplement lancer:

    docker-compose up

et l'application se lance en mode développement. Les modifications apportées au code sont automatiquement
appliqué dans le conteneur.


Pour faire rouller la suite de test, il faut faire la commande:

    docker exec -it crabe-inventaire_api /app/vendor/bin/phpunit

## Choix technologiques

### Backend : Lumen (PHP Laravel léger)

Ce framework web est une bonne porte d'entrée dans le développement web pour les programmeurs de tout niveau

### Front-end : Encore inconnue


## Licence 

GNU GENERAL PUBLIC LICENSE
Version 3, 29 June 2007

Copyright (C) 2007 Free Software Foundation, Inc. <https://fsf.org/>
Everyone is permitted to copy and distribute verbatim copies
of this license document, but changing it is not allowed.
