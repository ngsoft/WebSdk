@echo off
setlocal
call "%~dp0..\lib\sdk\getenv.bat"
"%php81%php.exe" "%sdk%composer.phar" %*