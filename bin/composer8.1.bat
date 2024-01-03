@echo off
setlocal
call "%~dp0..\lib\sdk\loadenv.bat"
set "php=%php81%"
call %~dp0composer.bat %*