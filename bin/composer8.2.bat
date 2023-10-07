@echo off
setlocal
call "%~dp0..\lib\sdk\loadenv.bat"
"%php82%php.exe" "%sdk%composer.phar" %*