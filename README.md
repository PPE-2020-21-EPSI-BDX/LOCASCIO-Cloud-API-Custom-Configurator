
## Badges

[![MIT License](https://img.shields.io/apm/l/atomic-design-ui.svg?)](https://github.com/tterb/atomic-design-ui/blob/master/LICENSEs)
[![CodeFactor](https://www.codefactor.io/repository/github/l-clem/bidgames/badge)](https://www.codefactor.io/repository/github/l-clem/bidgames)
![GitHub repo size](https://img.shields.io/github/repo-size/L-Clem/BidGames)
![Maintenance](https://img.shields.io/maintenance/yes/2022)
![PHP requirements](https://img.shields.io/badge/php%20version-%3D8.0.13-blue)
# LO-CASCIO Cloud Back

An API server and its seeder dedicated to the creation of an online configurator of computer equipment made in the framework of a school project at EPSI Bordeaux.


## Tech Stack

**Server:** Api-Platform, Symfony


## Features

- A full featured API " with authentification by JWT tokens " ( in progress ).


## FAQ

#### Where's the API documentation ?

The API documentation is available on the *Swagger API* page of the application (see **Run Locally** for more informations).

#### What's the E/R diagram of your database ?

Here's our E/R diagram (made with [DBeaver](https://dbeaver.io/)) :
![](https://cpx.locascio.fr/media/LO-CASCIO-CLOUD-Back/2.png)


## Run Locally
*❗ You can't run this project without the keys needed for authentification*

Download the project

```bash
  https://cpx.locascio.fr/media/LO-CASCIO-CLOUD-Back/LOCASCIO-Cloud-API-Custom-Configurator.zip
```

Unzip and go to the project directory

```bash
  cd LOCASCIO-Cloud-API-Custom-Configurator
```

Install dependencies after installing yarn

```bash
  composer u --ignore-platform-reqs && composer i 
```

Then start a terminal for each commands

```bash
  php -S localhost:8080 -t public
```

Now you can go on your browser and type :
- http://localhost:8080/api to get to the API documentation.

## Authors
- [@ClemLcs](https://github.com/ClemLcs)
