Rename-Item -Path ".env.example" -NewName ".env"

php artisan migrate

npm install
npm run build

composer install
composer update

composer dump-autoload

php artisan config:clear
php artisan cache:clear
php artisan optimize
php artisan key:generate
php artisan config:cache

php artisan migrate

php -S localhost:44302 -t public
if ($LASTEXITCODE -ne 0) {  Write-Host "Laravel server failed to start!"
    pause
    exit
}

pause
