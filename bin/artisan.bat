@echo off
if exist artisan goto :main
echo Laravel artisan not found
echo Are you in a laravel project root folder ?
echo.
exit /b 1
:main
php8.4 artisan %*