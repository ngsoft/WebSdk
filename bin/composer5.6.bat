@echo off
setlocal
call "%~dp0..\lib\sdk\loadenv.bat"
"%php56%php.exe" "%sdk%composer-lts.phar" %*