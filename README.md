# directus pgsql poc

## Requirements

This repository requires [docker-devbox](https://github.com/gfi-centre-ouest/docker-devbox) to be installed, please
follow instructions on the [docs](https://github.com/gfi-centre-ouest/docker-devbox) to perform the installation.

## Usage

```
dc up -d
```

You may change environment configuration settings in `.bash_enter.env` file.

## Install directus api development environment
 
```
git clone https://github.com/directus/api.git ./api
cd api
composer install

# Install from command line
# You may skip the following lines if you want to install from directus app
ln -rfs ../config/api.php ./config
_RUN_OPTS="-e HTTP_HOST=api.mysql.directus.test" directus install:database
_RUN_OPTS="-e HTTP_HOST=api.mysql.directus.test" directus install:install -e admin@example.com -p admin -t "Directus POC"

_RUN_OPTS="-e HTTP_HOST=api.pgsql.directus.test" directus install:database
_RUN_OPTS="-e HTTP_HOST=api.pgsql.directus.test" directus install:install -e admin@example.com -p admin -t "Directus POC"
```

## Install directus app development environment
 
```
git clone https://github.com/directus/app.git ./app
cd app
npm install
ln -rfs ../config/config.js ./public
ln -rfs ../config/vue.config.js ./
```

## Run installer manually from directus app

- Start the app dev server (`npm run dev`)

- Open https://admin.directus.test into your browser

- Run setup as usual, with the following settings

MySQL:

| config   | value     |
| -------- | --------- |
| host     | db2       |
| port     | 3306      |
| user     | directus  |
| password | directus  |
| database | directus  |

PostgreSQL:

| config   | value     |
| -------- | --------- |
| host     | db        |
| port     | 5432      |
| user     | directus  |
| password | directus  |
| database | directus  |