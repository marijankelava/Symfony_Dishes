## Setup

# Symfony Dishes

This simple app is multilingual database consisted of meals, ingridients, categories and tags which can be searched by different criteria.

## Installation

Clone repository `git clone https://gitlab.com/marijan-kelava/symfony_dishes.git your-project`
Enter to project folder `cd your-project`
Checkout to master branch

## Docker Setup
 - create .env and copy contents of env.local
 - build docker containers `docker-compose build`
 - run `docker-compose up -d` to build up the containers 
 - login to `symfony_dishes_web` container `docker exec -it symfony_dishes_web bash` 
 - run commands:
    `composer install` ,
    `php bin/console do:sc:dr --force`,
    `php bin/console do:sc:cr`

- to load fixtures:
    `php bin/console do:fi:lo`

## Default database credentials:
 - server: symfony_dishes_db
 - username: user
 - password: user
 - database: db

## Request URL example
http://localhost:8888/meals/v1?per_page=10&page=1&lang=hr&with=category,tags,ingridients&diff_time=1987654321

http://localhost:8888/meals/v1?per_page=10&page=1&lang=en&with=category,tags,ingridients&diff_time=1987654321

## Sample Response
JSON
{ "type": "cicrcle", "radius": "3" "circumference": "12" "area": "10" }







