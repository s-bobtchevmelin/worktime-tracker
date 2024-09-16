# cd cardcraft.sarah-bobtchev-melin.com/cardcraft/api/
# chmod +x ./deploy-laravel.sh && ./deploy-laravel.sh

cp ../.env ./.env

composer install

php artisan key:generate

php artisan migrate

php artisan route:clear

php artisan cache:clear

php artisan view:clear

npm install

npm run build

php artisan serve