# Installation

## Via Docker

1. Lancer un conteneur Docker avec la commande suivante :
   `docker run -d -p 8080:80 -v ./config:/app/data/ --restart unless-stopped docker.nexus.farmvivi.fr/cnam/nfa021/burger/site:main`
2. Rendez-vous sur `http://<IP_HÔTE_DOCKER>:8080`, vous devriez tomber sur la page d'initialisation du site
3. Suivez les instructions de configuration [ici](#Configuration)

## Via Docker Compose

1. Créer un fichier `docker-compose.yml` avec le contenu suivant :

```yaml
version: "3"

services:
  burger:
    image: docker.nexus.farmvivi.fr/cnam/nfa021/burger/site:main
    ports:
      - 8080:80
    volumes:
      - ./config:/app/data/
    restart: unless-stopped
```

2. Lancer la commande `docker-compose up -d` ou `docker compose up -d` pour lancer le conteneur
3. Rendez-vous sur `http://<IP_HÔTE_DOCKER>:8080`, vous devriez tomber sur la page d'initialisation du site
4. Suivez les instructions de configuration [ici](#Configuration)

## Via WampServer

1. Cloner le projet dans le dossier `www` de WampServer
2. Rendez-vous sur `http://localhost/NFA021-Burger/public/`, vous devriez tomber sur la page d'initialisation du site
3. Suivez les instructions de configuration [ici](#Configuration)

# Configuration

## Configuration de la base de données

### Création de la base de données

1. Créer une base de données MariaDB avec l'intervalle de caractères `utf8mb3_general_ci` (Important !)

## Configuration du site

1. Rendez-vous sur la page d'initialisation du site
2. Remplissez les champs demandés
3. Terminez la configuration en cliquant sur le bouton `Terminez l'installation`
