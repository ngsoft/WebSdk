@echo off
setlocal
call "%~dp0stop.bat"
call "%~dp0..\sdk\loadenv.bat"
call %sdk%scripts\start-cgi.bat
call %sdk%scripts\start-nginx.bat