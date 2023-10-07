@echo off
setlocal
call "%~dp0..\lib\sdk\getenv.bat"
"%php56%php.exe" "%sdk%composer-lts.phar" %*