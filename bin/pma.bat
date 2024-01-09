@echo off

if exist "%~dp0..\var\www\phpMyAdmin" (
    echo Openning http://localhost/phpmyadmin
    start "" "http://localhost/phpmyadmin/index.php?route=/"
)
