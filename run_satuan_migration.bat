@echo off
cd /d c:\laragon\www\Talaund
php artisan migrate
php artisan db:seed --class=MSatuanSeeder
pause
