@echo off
setlocal
call "%~dp0..\lib\sdk\getenv.bat"
"%php82%php.exe" "%sdk%composer.phar" %*