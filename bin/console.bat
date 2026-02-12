@echo off
if exist bin\console goto main
echo Symfony console not found
echo Are you in a symfony project root folder ?
exit /b 1

:main
php bin\console %*
