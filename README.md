
## Installation

Alternative installation is possible with local environment and dependencies .

# Main Methods Relying on Laravel Sail & Docker :
Clone the repository

    git clone git@github.com:zaxx44a/get-and-earn.git

Switch to the repo folder

    cd get-and-earn

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Building Project Container

    ./vendor/bin/sail up -d

Give Permission to logs and cache

    sudo chmod -cR 777 storage/

Run the database migrations

    ./vendor/bin/sail artisan migrate --seed


Install  all the dependencies using npm

    npm i &&  npm run build


You can now access the server at 

**[0.0.0.0:8080](http://0.0.0.0:8080/)**


# Alternative Methods Relying on Local Environment : 
Please check the official laravel installation guide for any requirements before you start. [Official Documentation](https://laravel.com/docs/9.x/installation)

Clone the repository

    git clone git@github.com:zaxx44a/get-and-earn.git

Switch to the repo folder

    cd get-and-earn

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Create Database Locally, Set the database connection and change DB_HOST to 

    DB_HOST=127.0.0.1

Run the database migrations and seeding

    php artisan migrate --seed

Give Permission to logs and cache

    sudo chmod -cR 777 storage/

Install  all the dependencies using npm

    npm i &&  npm run build

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

# Testing credentials

**Admin**

    phone: +962799637977
    password: password

**User**

    phone: +96226236564
    password: password


# Docker Configuration

you can edit port forwarding with your suitable port for your device in **.env** file:

```
APP_PORT=8080
VITE_PORT=5173
FORWARD_DB_PORT=3307
FORWARD_REDIS_PORT=6378
FORWARD_MEILISEARCH_PORT=7701
FORWARD_MAILHOG_PORT=1026
FORWARD_MAILHOG_DASHBOARD_PORT=8026
```

----------


