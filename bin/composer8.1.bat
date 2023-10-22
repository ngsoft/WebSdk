@echo off
setlocal
call "%~dp0..\lib\sdk\loadenv.bat"
"%php81%php.exe" "%~dp0composer.phar" %*