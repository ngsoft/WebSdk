@echo off
setlocal
call "%~dp0..\lib\sdk\getenv.bat"
"%php%php.exe" "%sdk%composer.phar" %*