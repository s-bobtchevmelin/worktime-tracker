# Run this avec deployed on circle ci
# cd worktime-tracker.sarah-bobtchev-melin.com/admin
# chmod +x ./deploy-laravel.sh && ./deploy-laravel.sh

cp ../.env ./.env

composer install

npm install

php artisan config:clear

php artisan migrate -n

php artisan route:clear

php artisan view:clear

php artisan cache:clear

php artisan serve