# Projet Tutoré 2022-2023

## Sujet : Flux vidéo

---

### Membres de l'équipe

- [Cyprien COTINAUT](https://github.com/lecyp12)
- [Teddy CLÉMENT DELS](https://github.com/cdteddyk1)
- [Christopher JUE](https://github.com/JUEChristopher)
- [Ugo ZANZI](https://github.com/uzanzi)
- [Bradley BARBIER](https://github.com/Catif)

---

### Description

Le projet Scudo (ou Flux vidéos) est une application web qui
s’apparente a un réseau social, intégrant des fonctionnalités d’utilité
publique.

Dans un monde où les technologies sont de plus en plus présentes.
Il n’est pas surprenant de voir une vidéo partager sur les réseaux
sociaux qui dénonce un drame, une agression, un abus de pouvoir,
ou quelconque forme d’incivilité. Seulement, vous êtes-vous déjà
demandé combien de ces vidéos non jamais vu le jour ? Parce que oui,
un appareil électronique tel qu’un téléphone portable a des capacités
extraordinaires, mais n’est pas encore incassable. Par conséquent
bon nombre de vidéos apportant des preuves pour des potentielles
poursuites judiciaires ont tout simplement disparu.

C’est à partir de ce constat que Scudo prend tout son sens.
Une plateforme de diffusion en direct ou en différé, qui lors
d’enregistrements ou de diffusions en direct, envoie de manière
régulière le flux vidéo au serveur pour le sauvegarder et donc éviter sa
perte.

---

### Installation

#### Prérequis

- PHP dans sa version 7.4 ou supérieure
- NodeJS dans sa version 14 ou supérieure
- ffmpeg

#### Configuration

##### API

Allez dans le dossier /api/conf et copiez le fichier db.ini.example en db.ini et remplisser les informations de connexion à la base de données.

```bash
...
username=root           # Nom de connexion
password=               # Mot de passe de connexion
host=localhost          # Adresse du serveur
database=LP-PTUT_Scudo  # Nom de la base de données
```

##### Server-stream

Allez dans /server-stream/conf/configuration.js et modifier la conf.api_url.

```js
const conf = {
  // ...
  api_url: "http://localhost:8000", // Adresse de l'API
  // ...
};
```

##### Front

Allez dans le dossier /front et copiez le fichier .env.example en .env et remplisser les informations de connexion à l'API.

```bash
VITE_API_URL = "http://localhost:8000"; // Adresse de l'API
```

#### Commandes

##### API

Allez dans le dossier /api et exécutez la commande suivante :

```bash
composer install
```

Allez dans le dossier /api/public et exécutez la commande suivante :

```bash
# 'port' est le port sur lequel vous voulez lancer le serveur API
php -S localhost:port
```

##### Server-stream

Allez dans le dossier /server-stream et exécutez la commande suivante :

```bash
npm install
```

Dans ce même dossier exécutez la commande suivante :

```bash
node server.js
```

##### Front

Allez dans le dossier /front et exécutez la commande suivante :

```bash
npm install
```

Dans ce même dossier exécutez la commande suivante :

```bash
npm run dev
```

OU si vous voulez créer les fichiers de production :

```bash
npm run build
```
