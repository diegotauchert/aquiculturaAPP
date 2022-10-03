#!/bin/bash

php artisan down

git stash save --keep-index

git stash drop

git pull

composer install -o --no-dev

php artisan config:clear

php artisan cache:clear

php artisan up
