@echo off

set WEB_SDK=C:\WebSdk\

pushd "%~dp0.."
    set lib=%cd%\
    set sdk=%~dp0
    set nvm=%lib%nvm\
    set mariadb=%lib%mariadb\
    set nginx=%lib%nginx\
    set php81=%lib%\php\8.1\
    set php82=%lib%\php\8.2\
    set php74=%lib%\php\7.4\
    set php56=%lib%\php\5.6\
    set php=%php81%
    
popd

