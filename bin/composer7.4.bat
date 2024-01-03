@echo off
setlocal
call "%~dp0..\lib\sdk\loadenv.bat"
set "php=%php74%"
call %~dp0composer.bat %*
