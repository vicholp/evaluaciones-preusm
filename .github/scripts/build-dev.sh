#! /bin/bash

cp .env.integration .env
cp public/.htaccess.example public/.htaccess

chmod a+w -R ./bootstrap/
chmod a+w -R ./storage/

composer install --no-ansi --no-interaction --no-progress --optimize-autoloader
npm ci

php artisan storage:link --relative

npm run prod
