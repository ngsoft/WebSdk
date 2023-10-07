@echo off
setlocal
call "%~dp0..\lib\sdk\getenv.bat"
"%php74%php.exe" "%sdk%composer.phar" %*