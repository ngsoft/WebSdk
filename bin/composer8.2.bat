@echo off
setlocal
call "%~dp0..\lib\sdk\loadenv.bat"
set "php=%php82%"
call %~dp0composer.bat %*