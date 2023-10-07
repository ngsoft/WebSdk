@echo off
setlocal
call "%~dp0..\lib\sdk\loadenv.bat"
"%php74%php.exe" "%sdk%composer.phar" %*