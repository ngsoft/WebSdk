@echo off
setlocal
call "%~dp0..\lib\sdk\loadenv.bat"
"%php%php.exe" "%~dp0composer.phar" %*