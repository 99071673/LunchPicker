Rename-Item -Path ".env.example" -NewName ".env"

composer install

npm install
npm run build

php artisan key:generate

php artisan migrate

php artisan config:cache
php artisan cache:clear

php -S localhost:44302 -t public
pause